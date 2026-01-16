<?php

namespace App\Modules\Auth\Services;

use App\Models\User;
use App\Modules\Auth\DTO\LoginWithCodeData;
use App\Modules\Auth\DTO\SendCodeData;
use App\Modules\Auth\Models\OtpCode;
use Carbon\Carbon;
use Exception;
use http\Exception\UnexpectedValueException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AuthService
{
    /**
     * @param SendCodeData $data
     * @return string[]
     */
    public function sendCode(SendCodeData $data): array
    {
        try {
            OtpCode::query()->updateOrInsert(
                ['email' => $data->email],
                [
                    'code' => $data->code,
                    'expires_at' => Carbon::now()->addMinutes(15),
                    'created_at' => Carbon::now()
                ]
            );
            //TODO тут можна додати queue якщо треба додам
            Mail::raw("Твій код для входу в гру: $data->code", function ($message) use ($data) {
                $message->to($data->email)->subject('Код доступу');
            });
        } catch (Throwable $t) {
            Log::error('OTP send failed', [
                'email' => $data->email,
                'error' => $t->getMessage(),
            ]);

            abort(500, $t->getMessage());
        }

        return ['message' => 'Code has been sent to your email.'];
    }

    /**
     * @param LoginWithCodeData $data
     * @return array
     */
    public function loginWithCode(LoginWithCodeData $data): array
    {
        try {
            $record = DB::table('otp_codes')
                ->where('email', $data->email)
                ->where('code', $data->code)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (!$record) {
                throw new Exception('Wrong code');
            }

            $user = User::firstOrCreate(
                ['email' => $data->email],
                ['name' => explode('@', $data->email)[0], 'email_verified_at' => now()]
            );

            DB::table('otp_codes')->where('email', $data->email)->delete();
            $token = $user->createToken('auth_token')->plainTextToken;
        } catch (Throwable $t) {
            Log::error('Login with code failed', [
                'email' => $data->email,
                'error' => $t->getMessage(),
            ]);

            abort(500, $t->getMessage());
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ];
    }
}


