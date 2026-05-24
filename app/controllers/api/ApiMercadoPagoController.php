<?php 
namespace app\controllers\api;

use app\services\MercadoPagoService;

class ApiMercadoPagoController
{
    private MercadoPagoService $mercadoPago;

    public function __construct() {
        $this->mercadoPago = new MercadoPagoService;
    }
    public function preference()
    {
        $preference = $this->mercadoPago->preference();

        header('Content-Type: application/json');

        if ($preference) {
            echo json_encode($preference, JSON_PRETTY_PRINT);
        }

        echo json_encode([
            'message' => 'nao deu'
        ], JSON_PRETTY_PRINT);
    }
}





?>