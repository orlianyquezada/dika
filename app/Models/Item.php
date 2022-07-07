<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Condition;
use App\Models\Status;

class Item extends Model
{
    use SoftDeletes;

    protected $table = 'items';

    protected $fillable = ['datetime_it', 'item_it', 'quanty_it', 'qty_boxes_it', 'ubication_it', 'observation_it', 'customer_id', 'shipment_id', 'employee_id', 'item_id', 'user_id','sub_customer_id'];

    /**
     * The conditions that belong to the items.
     */
    public function conditions()
    {
        return $this->belongsToMany(Condition::class);
    }

    /**
     * The status that belong to the items.
     */
    public function status()
    {
        return $this->belongsToMany(Status::class);
    }
}
