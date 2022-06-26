<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InputMovement extends Model
{
    use SoftDeletes;

    protected $table = 'input_movements';

    protected $fillable = ['id', 'datetime_inm', 'item_inm', 'quanty_inm', 'qty_boxes_inm', 'ubication_inm', 'observation_inm', 'customer_id', 'condition_id', 'status_id', 'user_id'];
}
