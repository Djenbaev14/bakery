<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fine extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function responsible():BelongsTo{
        return $this->BelongsTo(User::class,'responsible_id','id');
    }
    public function user():BelongsTo{
        return $this->BelongsTo(User::class,'user_id','id');
    }
}
