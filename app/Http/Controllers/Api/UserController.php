<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
  public function compra(Request $request){
    //hacer una compra
    error_log('primera linea usercontroller.compra');
    $user = User::firstOrCreate(
      [
          'correo' => $request->input('correo')
      ],
      [
          'clave' => Hash::make(Str::random(12)),
          'nombre' => $request->input('nombre') . ' ' . $request->input('apellido'),
          'direccion' => $request->input('direccion'),
          'ciudad' => $request->input('ciudad'),
      ]
    );
  error_log('despues de firstorcreate usercontroller.compra');

  try {
      $payment = $user->charge(
          $request->input('amount'),
          $request->input('payment_method_id')
      );

      $payment = $payment->asStripePaymentIntent();

      $orden = $user->ordenes()
          ->create([
              'transaccion_id' => $payment->charges->data[0]->id,
              'total' => $payment->charges->data[0]->amount
          ]);

      foreach (json_decode($request->input('cart'), true) as $item) {
        error_log($item['cantidad']);
          $orden->productos()
              ->attach($item['id'], ['cantidad' => $item['cantidad']]);
      }

      error_log('despues de foreach');

      $orden->load('productos');
      error_log('orden 2: ');
      return $orden;

  } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 500);
  }
  }
}
