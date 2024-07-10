<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenditureType extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function expenditure():HasMany{
        return $this->hasMany(Expenditure::class);
    }
}
