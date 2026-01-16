<?php

namespace App\Modules\RoomBooking\Requests;

use App\Modules\RoomBooking\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class RoomBookingRequests extends FormRequest
{
    public function rules(): array
    {
        return [
            'room_id' =>
                [
                    'required',
                    'integer',
                    Rule::exists('rooms', 'id')->where(function ($query) {
                        $query->where('is_active', true);
                    }),
                ],
            'start_time' => 'required|date_format:Y-m-d H:i:s|after:now',
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->any()) {
                return;
            }
            $busyHours = Booking::query()
                ->where('room_id', $this->room_id)
                ->where('start_time', '<', $this->end_time)
                ->where('end_time', '>', $this->start_time)
                ->exists();

            if ($busyHours) {
                $validator->errors()->add(
                    'start_time',
                    "busy hours: {$this->start_time} - {$this->end_time}"
                );
            }
        });
    }
}
