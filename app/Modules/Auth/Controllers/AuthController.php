<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\DTO\LoginWithCodeData;
use App\Modules\Auth\DTO\SendCodeData;
use App\Modules\Auth\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendCode(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $result = $this->authService->sendCode
        (
            SendCodeData::from(
                [
                    'email' => $request->get('email'),
                    'code' => rand(100000, 999999)
                ]
            )
        );

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function loginWithCode(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string'
        ]);

        $result = $this->authService->loginWithCode
        (
            LoginWithCodeData::from(
                [
                    'email' => $request->get('email'),
                    'code' => $request->get('code'),
                ]
            )
        );

        return response()->json($result);
    }
}
