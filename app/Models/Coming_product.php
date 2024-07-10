<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coming_product extends Model
{
    use HasFactory;
    
    protected $guarded=['id'];

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
    public function supplier():BelongsTo{
        return $this->belongsTo(Supplier::class);
    }

    public function expenditure_coming_product():HasMany{
        return $this->hasMany(Expenditure_coming_product::class);
    }
}
