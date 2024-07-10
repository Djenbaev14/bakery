<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function coming_product():HasMany{
        return $this->hasMany(Coming_product::class);
    }
    public function transfers_to_supplier():HasMany{
        return $this->hasMany(Transfers_to_supplier::class);
    }
}
