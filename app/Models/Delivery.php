<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function bread():BelongsTo{
        return $this->BelongsTo(Bread::class);
    }
    public function responsible():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function truck():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
