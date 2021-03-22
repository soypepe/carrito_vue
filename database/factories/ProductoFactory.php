<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ProductoFactory extends Factory
{

    protected $model = Producto::class;

    public function definition()
    {
      $productoSufijo = ['Sueter', 'Pantalones', 'Camisa', 'Traje', 'Polera'];

      $nombre = $this->faker->company . ' ' . Arr::random($productoSufijo);

        return [
            'nombre' => $nombre,
            'slug' => Str::slug($nombre, '-'),
            'descripcion' => $this->faker->realText(150),
            'precio' => $this->faker->numberBetween(10000,25000)
        ];
    }
}
