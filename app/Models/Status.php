<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = ['status_st'];

    /**
     * The items that belong to the conditions.
     */
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
