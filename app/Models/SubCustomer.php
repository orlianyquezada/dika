<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCustomer extends Model
{
    use SoftDeletes;

    protected $table = 'sub_customers';

    protected $fillable = ['customer_id','sub_customer_id'];
}
