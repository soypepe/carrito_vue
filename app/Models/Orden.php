<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function usuario(){
      return $this->belongsTo(User::class);
    }

    public function productos(){
      return $this->belongsToMany(Producto::class)
        ->withPivot('cantidad');
    }
}
