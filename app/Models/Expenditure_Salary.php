<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expenditure_Salary extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function user():BelongsTo{
        return $this->BelongsTo(User::class);
    }
    public function expenditure():BelongsTo{
        return $this->BelongsTo(Expenditure::class);
    }

}
