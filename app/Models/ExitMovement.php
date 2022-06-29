<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExitMovement extends Model
{
    use SoftDeletes;

    protected $table = 'exit_movements';

    protected $fillable = ['datetime_exm', 'address_exm', 'observation_exm', 'input_movement_id', 'customer_id', 'condition_id', 'status_id', 'shipment_id', 'employee_id', 'user_id'];
}
