<?php

define("KEY_TOKEN", "DONcomedia4587$");
define("CLIENT_ID", "AZcWlp_ybBU9TIAPQRw1wUiDxZt5OMrGbBpUiqcz619eD6Ky-pwKfKqsIEUuhPuI38Lq5xRiNSE0RMIX");
define("TOKEN_MP", "TEST-2608625634008713-051023-7317f7a57923d8fa4b2b8ad656220051-1745978036");
define("CURRENCY","USD");
define("MONEDA", "S/");

session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>