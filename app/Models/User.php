<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable  = ['username','role_id','phone','KPI','password','created_at','updated_at'];

    public function sale():HasMany{
        return $this->hasMany(Sale::class);
    }
    public function role():BelongsTo{
        return $this->BelongsTo(Role::class);
    }
    public function client():HasMany{
        return $this->HasMany(Client::class);
    }
    public function user_salary():HasMany{
        return $this->HasMany(User_salary::class);
    }
    public function production():HasMany{
        return $this->HasMany(Production::class,'responsible_id', 'id');
    }

    public function expenditure():HasMany{
        return $this->hasMany(Expenditure::class);
    }
    public function payment_history():HasMany{
        return $this->hasMany(payment_history::class);
    }
    public function bread_product():HasMany{
        return $this->hasMany(Bread_product::class);
    }
    public function refund_bread():HasMany{
        return $this->hasMany(Refund_bread::class);
    }
    public function return_bread():HasMany{
        return $this->hasMany(Return_bread::class);
    }
    public function expenditure_coming_product():HasMany{
        return $this->hasMany(Expenditure_coming_product::class);
    }
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
