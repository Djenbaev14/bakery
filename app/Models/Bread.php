<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bread extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function delivery():HasMany{
        return $this->hasMany(Delivery::class);
    }

    public function sale():HasMany{
        return $this->hasMany(Sale::class);
    }
    public function sale_history():HasMany{
        return $this->hasMany(sale_history::class);
    }
    public function bread_product():HasMany{
        return $this->hasMany(Bread_product::class);
    }

    public function production():HasMany{
        return $this->hasMany(Production::class);
    }

    public function refund_bread():HasMany{
        return $this->hasMany(Refund_bread::class);
    }
    public function return_bread():HasMany{
        return $this->hasMany(Return_bread::class);
    }
    
}
