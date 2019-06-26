<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidForBuy extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'place',
        'seller_name',
        'phone_number',
        'price',
    ];

    /**
     * @var string
     */
    protected $table = 'bid_for_buys';

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}

