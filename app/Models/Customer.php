<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Item;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = ['name_cu','phone_cu','email_cu'];

    public function customerAsSubCustomer(){
        return $this->belongsToMany(Customer::class, 'sub_customers', 'customer_id', 'sub_customer_id');
    }

    public function customerAsCustomer(){
        return $this->belongsToMany(Customer::class, 'sub_customers', 'sub_customer_id', 'customer_id');
    }
}
