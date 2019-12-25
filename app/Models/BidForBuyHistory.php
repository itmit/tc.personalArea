<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidForBuyHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bid_for_buy_histories';

    protected $guarded = ['id'];
}
