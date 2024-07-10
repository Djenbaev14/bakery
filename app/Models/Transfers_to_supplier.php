<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfers_to_supplier extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function supplier():BelongsTo{
        return $this->belongsTo(Supplier::class);
    } 
}
