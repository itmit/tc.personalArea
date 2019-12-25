<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidForSaleHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bid_for_sale_histories';

    protected $guarded = ['id'];
}
