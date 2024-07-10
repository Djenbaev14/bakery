<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expenditure_product extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    
    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
    public function production():BelongsTo{
        return $this->belongsTo(Production::class);
    }
}
