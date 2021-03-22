<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Producto;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Producto::factory(20)->create();
        Categoria::factory(5)->create();

        $categorias = Categoria::all();
        Producto::all()->each(function ($producto) use ($categorias) {
          $producto->categorias()->attach(
            $categorias->random(2)->pluck('id')->toArray()
          );
        });
    }
}
