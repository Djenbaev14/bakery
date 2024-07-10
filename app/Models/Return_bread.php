<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Return_bread extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function sale():BelongsTo{
        return $this->BelongsTo(Sale::class);
    }
    public function sale_item():BelongsTo{
        return $this->belongsTo(Sale_items::class);
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function client():BelongsTo{
        return $this->belongsTo(Client::class);
    }
}
