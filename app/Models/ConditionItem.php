<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConditionItem extends Model
{
    protected $table = 'condition_item';

    protected $fillable = ['item_id', 'condition_id', 'user_id'];
}
