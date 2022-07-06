<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCustomer extends Model
{
    protected $table = 'sub_customers';

    protected $fillable = ['customer_id','sub_customer_id'];
}
