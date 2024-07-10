<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Production extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function responsible():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function bread():BelongsTo{
        return $this->belongsTo(Bread::class);
    }
    public function expenditure_product():HasMany{
        return $this->hasMany(Expenditure_product::class);
    }
}
