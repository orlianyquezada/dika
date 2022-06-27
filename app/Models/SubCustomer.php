<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCustomer extends Model
{
    use SoftDeletes;

    protected $table = 'sub_customers';

    protected $fillable = ['primary_customer_id', 'secondary_customer_id', 'phone_sc', 'email_sc'];
}
