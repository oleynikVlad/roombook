<?php

namespace App\Models;

use Database\Factories\RoomFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

#[UseFactory(RoomFactory::class)]
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $capacity
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Booking> $bookings
 * @property-read int|null $bookings_count
 * @method static \Database\Factories\RoomFactory factory($count = null, $state = [])
 * @method static Builder<static>|Room newModelQuery()
 * @method static Builder<static>|Room newQuery()
 * @method static Builder<static>|Room query()
 * @method static Builder<static>|Room whereCapacity($value)
 * @method static Builder<static>|Room whereCreatedAt($value)
 * @method static Builder<static>|Room whereDescription($value)
 * @method static Builder<static>|Room whereId($value)
 * @method static Builder<static>|Room whereIsActive($value)
 * @method static Builder<static>|Room whereName($value)
 * @method static Builder<static>|Room whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Room extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
