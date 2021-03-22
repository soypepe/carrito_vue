<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categorias(){
      return $this->belongsToMany(Categoria::class);
    }

    public function ordenes(){
      return $this->belongsToMany(Orden::class);
    }
}
