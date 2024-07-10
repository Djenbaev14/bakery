<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expenditure_production extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function expenditure_coming_product():HasMany{
        return $this->hasMany(Expenditure_coming_product::class);
    }
}
