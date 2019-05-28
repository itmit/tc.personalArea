<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class BidForSale extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'place_number',
        'seller_name',
        'phone_number',
        'price',
    ];

    /**
     * @var string
     */
    protected $table = 'bid_for_sale';
}
