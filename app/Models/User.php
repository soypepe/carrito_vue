<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

    protected $guarded = [];
    protected $hidden = [
        'clave',
        'remember_token',
    ];

    public function ordenes(){
      return $this->hasMany(Orden::class);
    }
}
