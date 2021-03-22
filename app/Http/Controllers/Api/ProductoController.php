<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
  public function index(){
    return Producto::with('categorias:id,nombre')
      ->get();
  }
}
