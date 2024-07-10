<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expenditure extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function user():BelongsTo{
        return $this->BelongsTo(User::class,'responsible_id','id');
    }

    public function expenditure_type():BelongsTo{
        return $this->BelongsTo(ExpenditureType::class);
    }
    public function expenditure_salary():HasMany{
        return $this->HasMany(Expenditure_Salary::class);
    }
}
