<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function bread():BelongsTo{
        return $this->BelongsTo(Bread::class);
    }
    public function sale_history():HasMany{
        return $this->hasMany(sale_history::class);
    }
    public function client():BelongsTo{
        return $this->belongsTo(Client::class);
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function user_salary():HasMany{
        return $this->HasMany(User_salary::class);
    }
    public function return_bread():HasMany{
        return $this->HasMany(Return_bread::class);
    }
}
