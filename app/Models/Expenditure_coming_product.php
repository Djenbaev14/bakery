<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\HasMany;

class Expenditure_coming_product extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function expenditure_product():BelongsTo
    {
        return $this->BelongsTo(Expenditure_product::class, 'expenditure_product_id');
    }

    public function coming_product():BelongsTo
    {
        return $this->BelongsTo(Coming_product::class);
    }

    public function user():BelongsTo{
        return $this->BelongsTo(User::class);
    }
}
