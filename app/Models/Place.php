<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Place
 * @package App\Models
 */
class Place extends Model
{
    /**
     * @var string
     */
    protected $table = 'place';

    /**
     * @var
     */
    protected $fillable = [
        'block',
        'floor',
        'row',
        'price',
        'place_number',
        'status',
    ];
}
