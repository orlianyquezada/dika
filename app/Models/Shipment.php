<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Shipment extends Model
{
    protected $table = 'shipments';

    protected $fillable = ['shipment_sh'];

    /**
     * Get the item that owns the shipment.
     */
    public function items()
    {
        return $this->belongsTo(Item::class);
    }
}
