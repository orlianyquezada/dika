<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Condition extends Model
{
    protected $table = 'conditions';

    protected $fillable = ['condition_co'];

    /**
     * The items that belong to the conditions.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
