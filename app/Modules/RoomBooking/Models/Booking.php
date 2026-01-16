<?php

namespace App\Modules\RoomBooking\Models;

use App\Models\User;
use Database\Factories\BookingFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $room_id
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property-read Room $room
 * @property-read User $user
 * @method static BookingFactory factory($count = null, $state = [])
 * @method static Builder<static>|Booking newModelQuery()
 * @method static Builder<static>|Booking newQuery()
 * @method static Builder<static>|Booking query()
 * @method static Builder<static>|Booking whereEndTime($value)
 * @method static Builder<static>|Booking whereId($value)
 * @method static Builder<static>|Booking whereRoomId($value)
 * @method static Builder<static>|Booking whereStartTime($value)
 * @method static Builder<static>|Booking whereUserId($value)
 * @mixin Eloquent
 */
class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected static function newFactory(): BookingFactory|Factory
    {
        return BookingFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
