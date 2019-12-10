<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Представляет сущность место, которое представляет конкретное помещение в блоке.
 *
 * @package App\Models
 */
class Place extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'places';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block',
        'floor',
        'row',
        'price',
        'place_number',
        'status',
        'sort'
    ];

    public static function checkValidPlaceNumber(string $block, string $floor, string $number, string $row) : ?Place
    {
        return Place::whereRaw("place_number = \"$number\" and block = \"$block\" and floor = \"$floor\" and row = \"$row\"")->first();
    }

    public function reservation()
    {
        return $this->hasOne(Reservation::class, 'place_id');
    }
}
