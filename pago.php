<?php

require 'config/config.php';
require 'config/database.php';
require 'vendor/autoload.php';

MercadoPago\SDK::setAccessToken(TOKEN_MP);

$preference = new MercadoPago\Preference();
$productos_mp = array();


$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;



$lista_carrito = array();

if($productos !=null){
    foreach($productos as $clave => $cantidad){
        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE 
        id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    header("Location: index.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORPORACION MILO</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Poppins:wght@800&display=swap" rel="stylesheet">
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>" data-sdk-integration-source="button-factory"></script>
</head>
<body>
<div class="top-navbar">
        <p>HOLA</p>
        <div class="icons">
            <a href="login.html"><img src="./images/imagenes/register.png" alt="" width="18px">LOGIN</a>
            <a href="login.html"><img src="./images/imagenes/register.png" alt="" width="18px">REGISTER</a>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.html" id="logo"><span id="span1">C</span>ORPORACION<span>MILO</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><img src="./images/imagenes/menu.png" alt="" width="30px"></span> 
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.html">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Productos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorias
                    </a>
                    <ul class="dropdown-menu" style="background-color: rgb(67 0 86);">
                        <li><a class="dropdown-item" href="#">PROCESADORES</a></li>
                        <li><a class="dropdown-item" href="#">MOTHERBOARD</a></li>
                        <li><a class="dropdown-item" href="#">MEMORIAS RAM</a></li>
                        <li><a class="dropdown-item" href="#">ALMACENAMIENTO</a></li>
                        <li><a class="dropdown-item" href="#">FUENTES DE PODER</a></li>
                        <li><a class="dropdown-item" href="#">CASES</a></li>
                        <li><a class="dropdown-item" href="#">COOLER</a></li>
                        <li><a class="dropdown-item" href="#">PERIFERICOS</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contacto</a>
                </li>
            </ul>
            <form class="d-flex" id="seach">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="carrito.php">
                        <i class="fas fa-shopping-cart"></i><span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h4>Detalles de la compra</h4>
                <div class="row">
                    <div class="col-12">
                        <div id="smart-button-container">
                            <div style="text-align: center;">
                                <div id="paypal-button-container"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div style="text-align: center;">
                            <div class="checkout-btn"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($lista_carrito == null){ ?>
                                <tr>
                                    <td colspan="5" class="text-center"><b>Lista vacía</b></td>
                                </tr>
                            <?php } else {
                                $total = 0;
                                foreach($lista_carrito as $producto){
                                    $_id = $producto[0]['id'];
                                    $nombre = $producto[0]['nombre'];
                                    $precio = $producto[0]['precio'];
                                    $descuento = $producto[0]['descuento'];
                                    $cantidad = $producto[0]['cantidad'];
                                    $precio_desc = $precio - (($precio * $descuento) / 100);
                                    $subtotal = $cantidad * $precio_desc;

                                    $item = new MercadoPago\Item();
                                    $item->id = $_id;
                                    $item->title = $nombre;
                                    $item->quantity = $cantidad;
                                    $item->unit_price = $precio_desc;
                                    $item->currency_id = "PEN";

                                    array_push($productos_mp, $item);
                                    unset($item);
                            ?>
                                    <tr>
                                        <td><?php echo $nombre; ?></td>
                                        <td>
                                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?></div>
                                        </td>
                                    </tr>
                            <?php
                                    $total += $subtotal;
                                } ?>
                                <tr>
                                    <td colspan="2">
                                        <p class="h3 text-center" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

    <?php

    $preference->items = $productos_mp;
    $preference->back_urls = array(
        "success" => "http://localhost/WEB_INTEGRADO(SINGITHUB)/captura.php",
        "failure" => "http://localhost/WEB_INTEGRADO(SINGITHUB)/fallo.php",
    );
    $preference->auto_return = "approved";
    $preference->binary_mode = true;

    $preference->save();

    ?>



      <footer id="footer">
        <div class="footer-top">
          <div class="container">
            <div class="row">
  
              <div class="col-lg-3 col-md-6 footer-contact">
                <h3>Corporacion MILO</h3>
                <strong>Telefono:</strong> +51 981502686 <br>
                <strong>Email:</strong> sentrytadeo24@gmail.com <br>
              </div>
  
              <div class="col-lg-3 col-md-6 footer-links">
                <h4>Links</h4>
               <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Home</a></li>
                <li><a href="#">Home</a></li>
                <li><a href="#">Home</a></li>
                <li><a href="#">Home</a></li>
               </ul>
              </div>
  
  
  
             
  
              <div class="col-lg-3 col-md-6 footer-links">
                <h4>Services</h4>
  
               <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Home</a></li>
                <li><a href="#">Home</a></li>
                <li><a href="#">Home</a></li>
                <li><a href="#">Home</a></li>
               </ul>
              </div>
  
              <div class="col-lg-3 col-md-6 footer-links">
                <h4>Redes sociales</h4>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quia, quibusdam.</p>
  
                <div class="socail-links mt-3">
                  <a href="#"><i class="fa-brands fa-twitter"></i></a>
                  <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                  <a href="#"><i class="fa-brands fa-instagram"></i></a>
                  <a href="#"><i class="fa-brands fa-skype"></i></a>
                  <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                </div>
              
              </div>
  
            </div>
          </div>
        </div>
        <hr>
        <div class="container py-4">
          <div class="copyright">
            &copy; Copyright <strong><span>Corporacion MILO</span></strong>. Todos los derechos reservados
          </div>
          <div class="credits">
            Diseñado por <a href="#">Mi</a>
          </div>
        </div>
      </footer> 


      <a href="#" class="arrow"><i><img src="./images/imagenes/arrow.png" alt=""></i></a>

   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    function initPayPalButton() {
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'vertical',
                label: 'pay',
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{"description":"LA DESCRIPCION DE TU PRODUCTO","amount":{"currency_code":"<?php echo CURRENCY; ?>","value":<?php echo $total; ?>}}]
                });
            },

            onApprove: function(data, actions) {
                let url = 'clases/captura.php'; 
                return actions.order.capture().then(function(detalles) {

                    console.log('Detalles del pago:', detalles);

                    return fetch(url, { 
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        }, 
                        body: JSON.stringify({
                            detalles: detalles
                        })
                    }).then(function(response){
                        window.location.href = "completo.php?key=" +detalles['id'];
                    })
                });
            },

            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');
    }
    initPayPalButton();

    const mp = new MercadoPago('TEST-cde3b8b2-59ab-423e-a5e0-642c6ff3e377', {
            locale: 'es-PER'
        });

        mp.checkout({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: '.checkout-btn',
                label: 'Paga con Mercado Pago'
            }
        })
</script>



</body>
</html>