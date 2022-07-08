<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemStatus extends Model
{
    protected $table = 'item_status';

    protected $fillable = ['item_id', 'status_id', 'user_id'];
}
