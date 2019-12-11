<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidForSale extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'bid_for_sales';

    public function place()
    {
        return $this->belongsTo(Place::class, 'place');
    }
}
