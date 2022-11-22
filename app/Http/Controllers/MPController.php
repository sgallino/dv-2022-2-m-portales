<?php

namespace App\Http\Controllers;

use App\MercadoPago\PaymentManager;
use App\Models\Pelicula;
use Illuminate\Http\Request;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MPController extends Controller
{
    public function showForm()
    {
        // Configuramos el SDK de MercadoPago.
        // Noten que las variables de configuración se piden con la sintaxis:
        // 'nombrearchivo.clavearray'
        SDK::setAccessToken(config('mercadopago.access_token'));

        // Procedemos a crear la preferencia, y configurarla.
        $preference = new Preference();

        // Lo _mínimo_ que necesita la preferencia es la lista de ítems que queremos cobrar.
        // Por ejemplo, vamos a leer algunas películas de nuestra BBDD para usarlas como ítems.
        /** @var Pelicula[] $peliculas */
        $peliculas = Pelicula::findMany([1, 2, 3]);

        $items = [];

        foreach($peliculas as $pelicula) {
            $item = new Item();
            // Datos requeridos.
            $item->title = $pelicula->titulo;
            $item->unit_price = $pelicula->precio;
            $item->quantity = 1;

            // Datos opcionales.
            $item->id = $pelicula->pelicula_id;

            $items[] = $item;
        }

        $preference->items = $items;

        // Configuramos las URLs de retorno.
        // Estas son las rutas a donde MP nos va a redireccionar dependiendo del resultado del pago.
        // Nos va a mandar algunos datos de resultado.
        $preference->back_urls = [
            'success' => route('mp.success'),
            'pending' => route('mp.pending'),
            'failure' => route('mp.failure'),
        ];

        // "Grabamos" la preferencia (generamos el link de pago).
        $preference->save();

        return view('mp.payment', [
            'preference' => $preference,
            'publicKey' => config('mercadopago.public_key'),
        ]);
    }

    public function showFormUsingPaymentManager()
    {
        $payment = new PaymentManager();

        $payment
            ->setItems(Pelicula::findMany([1, 2, 3]))
            ->setBackUrls(
                success: route('mp.success'),
                pending: route('mp.pending'),
                failure: route('mp.failure'),
            )
            ->save();

        return view('mp.payment-manager', [
            'payment' => $payment,
        ]);
    }

    public function success(Request $request)
    {
        echo "Success!";
        dd($request->query());
    }

    public function pending(Request $request)
    {
        echo "Pending...";
        dd($request->query());
    }

    public function failure(Request $request)
    {
        echo "Failure.";
        dd($request->query());
    }
}
