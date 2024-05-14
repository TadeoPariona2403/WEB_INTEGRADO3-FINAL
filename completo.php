<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$id_transaccion = isset($_GET['key']) ? $_GET['key'] : '0';

$error = '';
if($id_transaccion == '') {
    $error = 'Error al procesar la petición';
} else {

    $sql = $con->prepare("SELECT count(id) FROM compra WHERE id_transaccion=? AND status=?");
        $sql->execute([$id_transaccion, 'COMPLETED']);
        if($sql->fetchColumn() > 0) {

            $sql = $con->prepare("SELECT id, fecha, email, total FROM compra WHERE id_transaccion=? AND status=?
             LIMIT 1");
            $sql->execute([$id_transaccion, 'COMPLETED']);
            $producto = $sql->fetch(PDO::FETCH_ASSOC);

            $idCompra = $producto['id'];
            $total = $producto['total'];
            $fecha = $producto['fecha'];

            $sqlDet = $con->prepare("SELECT nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
            $sqlDet->execute([$idCompra]);

        } else {
$error = 'Error al comprobar la compra';
        } 

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
                    <a class="nav-link" href="checkout.php">
                        <i class="fas fa-shopping-cart"></i><span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                    </a>
                </li>
                </ul>

            </div>
        </div>
    </nav>

    <main>
        <div class="container">

        <?php if(strlen($error) > 0) { ?>
            <div class="row">
                <div class="col">
                    <h3><?php echo $error; ?></h3>
                </div>
            </div>

            <?php } else { ?>

            <div class="row">
                <div class="col">
                    <b>Folio de la compra: </b><?php echo $id_transaccion; ?><br>
                    <b>Fecha de compra: </b><?php echo $fecha; ?><br>
                    <b>Total: </b><?php echo MONEDA . number_format($total, 2, '.', ','); ?><br>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Producto</th>
                                <th>Importe</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($producto_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) { 
                                $importe = $producto_det['precio'] * $producto_det['cantidad']; ?>
                                <tr>
                                    <td><?php echo $producto_det['cantidad']; ?></td>
                                    <td><?php echo $producto_det['nombre']; ?></td>
                                    <td><?php echo $importe; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>  
        </div>
    </main>
    
</body>
</html>