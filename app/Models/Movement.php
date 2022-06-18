<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $table = 'movements';

    protected $fillable = [
        'date_mo', 
        'item_mo', 
        'quanty_mo', 
        'qty_boxes_mo', 
        'ubication_mo', 
        'observation_mo', 
        'customer_id', 
        'condition_id', 
        'status_id', 
        'shipment_id', 
        'employee_id', 
        'movement_id', 
        'user_id'
    ];
}
