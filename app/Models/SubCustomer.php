<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCustomer extends Model
{
    use SoftDeletes;

    protected $table = 'sub-customers';

    protected $fillable = ['customer_id','name_sb','phone_sb','email_sb'];  
}
