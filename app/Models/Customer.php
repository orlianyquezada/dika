<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = ['name_cu','phone_cu','email_cu'];

    public function items(){
        return $this->hasMany(Item::class);
    }
}
