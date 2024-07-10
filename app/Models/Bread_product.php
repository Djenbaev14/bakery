<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bread_product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function bread():BelongsTo{
        return $this->belongsTo(Bread::class);
    }
    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
