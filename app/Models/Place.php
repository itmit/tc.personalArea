<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    protected $table = 'place';

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
    ];

    public static function checkValidPlaceNumber(string $block, string $floor, string $number) : ?Place
    {
        return Place::whereRaw("place_number = \"$number\" and block = \"$block\" and floor = \"$floor\"")->first();
    }
}
