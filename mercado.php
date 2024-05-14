<?php

require 'vendor/autoload.php';

MercadoPago\SDK::setAccessToken('TEST-2608625634008713-051023-7317f7a57923d8fa4b2b8ad656220051-1745978036');

$preference = new MercadoPago\Preference(); 

$item = new MercadoPago\Item();
$item->id = '0001';
$item->title = 'Producto lorem';
$item->quantity = 1;
$item->unit_price = 150.00;
$item->currency_id = "PEN";

$preference->items = array($item);

$preference->back_urls = array(
    "success" => "http://localhost/WEB_INTEGRADO(SINGITHUB)/captura.php",
    "failure" => "http://localhost/WEB_INTEGRADO(SINGITHUB)/fallo.php",
);

    $preference->auto_return = "approved";
    $preference->binary_mode = true;

$preference->save();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>

    <h3>Mercado pago</h3>

    <div class="checkout-btn"></div>

    <script>
        const mp = new MercadoPago('TEST-cde3b8b2-59ab-423e-a5e0-642c6ff3e377', {
            locale: 'es-PER'
        });

        mp.checkout({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: '.checkout-btn',
                label: 'Pagar con MP'
            }
        })
    </script>
    
</body>
</html>