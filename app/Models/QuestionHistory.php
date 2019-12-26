<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionHistory extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'question_histories';

    protected $guarded = ['id'];
}
