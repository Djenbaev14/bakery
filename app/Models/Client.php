<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function sale():HasMany{
        return $this->HasMany(Sale::class);
    }
    public function sale_history():HasMany{
        return $this->hasMany(sale_history::class);
    }
    public function user():BelongsTo{
        return $this->BelongsTo(User::class);
    }
    
    public function payment_history():HasMany{
        return $this->HasMany(payment_history::class);
    }

    public function return_bread():HasMany{
        return $this->hasMany(Return_bread::class);
    }
}
