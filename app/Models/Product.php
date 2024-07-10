<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function coming_product():HasMany{
        return $this->hasMany(Coming_product::class);
    }

    public function expenditure_product():HasMany{
        return $this->hasMany(Expenditure_product::class);
    }

    public function bread_product():HasMany{
        return $this->hasMany(Bread_product::class);
    }
    public function union():BelongsTo{
        return $this->belongsTo(Union::class);
    }
    
}
