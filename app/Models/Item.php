<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $table = 'items';

    protected $fillable = ['datetime_it', 'item_it', 'quanty_it', 'qty_boxes_it', 'ubication_it', 'observation_it', 'customer_id', 'condition_id', 'status_id', 'shipment_id', 'employee_id', 'movement_id', 'user_id'];
}
