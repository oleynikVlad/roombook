<?php

namespace App\Modules\RoomBooking\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\RoomBooking\DTO\RoomBookingDTO;
use App\Modules\RoomBooking\Requests\RoomBookingRequests;
use App\Modules\RoomBooking\Services\RoomBookingService;
use Illuminate\Http\JsonResponse;

class RoomBookingController extends Controller
{
    public function __construct(private readonly RoomBookingService $roomBookingService)
    {
    }

    /**
     * @param RoomBookingRequests $request
     * @return JsonResponse
     */
    public function book(RoomBookingRequests $request): JsonResponse
    {
        $result = $this->roomBookingService->book(RoomBookingDTO::from([
            'user_id' => $request->user()->id,
            ...$request->validated()
        ]));

        return response()->json($result);
    }
}
