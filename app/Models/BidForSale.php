<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidForSale extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'place',
        'seller_name',
        'phone_number',
    ];

    /**
     * @var string
     */
    protected $table = 'bid_for_sale';

    public function place()
    {
        return $this->belongsTo('App\Models\Place');
    }
}
