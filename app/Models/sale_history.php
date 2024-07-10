<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class sale_history extends Model
{
    use HasFactory;

    public $guarded=['id'];
    public function sale():BelongsTo{
        return $this->belongsTo(Sale::class);
    }
    public function client():BelongsTo{
        return $this->belongsTo(Client::class);
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
