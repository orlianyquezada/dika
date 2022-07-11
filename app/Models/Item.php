<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Condition;
use App\Models\Customer;
use App\Models\Status;
use App\Models\Shipment;
use App\User;

class Item extends Model
{
    use SoftDeletes;

    protected $table = 'items';

    protected $fillable = ['datetime_input_it', 'item_it', 'quanty_it', 'qty_boxes_it', 'ubication_it', 'observation_input_it', 'datetime_exit_it', 'address_it', 'observation_exit_it', 'customer_id', 'sub_customer_id', 'shipment_id', 'employee_id', 'user_id'];

    /**
     * Get the customer that owns the item.
     */
    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    /**
     * Get the sub customer that owns the item.
     */
    public function subCustomer()
    {
        return $this->belongsTo(Customer::class,'sub_customer_id');
    }

    /**
     * The conditions that belong to the items.
     */
    public function conditions()
    {
        return $this->belongsToMany(Condition::class)->withPivot('created_at','updated_at');
    }

    /**
     * The status that belong to the items.
     */
    public function status()
    {
        return $this->belongsToMany(Status::class)->withPivot('created_at','updated_at');
    }

    /**
     * Get the shipments that owns the item.
     */
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, );
    }

    /**
     * Get the employee that owns the item.
     */
    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }

    /**
     * Get the user that owns the item.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
