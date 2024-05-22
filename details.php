    <?php
    require 'config/config.php';
    require 'config/database.php';
    $db = new Database();
    $con = $db->conectar();

    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $token = isset($_GET['token']) ? $_GET['token'] : '';

    if($id == '' || $token == ''){
        echo 'Error en proceso de peticion';
        exit;
    } else {

        $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

        if($token == $token_tmp){

        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
        $sql->execute([$id]);
        if($sql->fetchColumn() > 0) {

            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id=? AND activo=1 
            LIMIT 1");
            $sql->execute([$id]);
            $producto = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $producto['nombre'];
            $descripcion = $producto['descripcion'];
            $precio = $producto['precio'];
            $descuento = $producto['descuento'];
            $precio_f = $precio - (($precio * $descuento) / 100);
            $dir_images = 'images/productos/' . $id .'/';

            $rutaImg = $dir_images . 'principal.png';

            if(!file_exists($rutaImg)){
                $rutaImg = 'images/no-photo.png';
            }

            $imagenes = array();
            if(file_exists($dir_images))
            {
            $dir = dir($dir_images);

            while(($archivo = $dir->read()) != false){
                if($archivo != 'principal.png' && (strpos($archivo, 'png') || strpos($archivo, 'jpg'))){
                    $imagenes[] = $dir_images . $archivo;
                }
            }
            $dir->close();
            }

            $sqlCaracter = $con->prepare ("SELECT DISTINCT(det.id_caracteristica) AS idCat, cat.caracteristica FROM de_pro_car 
            AS det INNER JOIN caracteristicas AS cat ON det.id_caracteristica=cat.id WHERE det.id_producto=?");
            $sqlCaracter->execute([$id]);

        }

        } else {
            echo 'Error en proceso de peticion';
            exit; 
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

<?php include 'header.php'; ?>

    <div class="container section-p1" id="prodetails product-cards">
        <div class="row">
            <div class="col-md-6">
                <div class="single-pro-image">
                    <img src="<?php echo $rutaImg; ?>" width="100%" id="MainImg" alt="">
                    <div class="small-img-group">
                        <div class="small-img-col">
                            <img src="" width="100%" class="small-img" alt="">
                        </div>
                        <div class="small-img-col">
                            <img src="" width="100%" class="small-img" alt="">
                        </div>
                        <div class="small-img-col">
                            <img src="" width="100%" class="small-img" alt="">
                        </div>
                        <div class="small-img-col">
                            <img src="" width="100%" class="small-img" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="single-pro-details">
                    <h6>Home / Producto</h6>
                    <h4><?php echo $nombre; ?></h4>

                    <?php if($descuento > 0 ) { ?>
                        <p><del><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></del></p>
                        <h2>
                        <?php echo MONEDA . number_format($precio_f, 2, '.', ','); ?>
                        <small class="text-success"><?php echo $descuento; ?>% de descuento</small>
                        </h2>

                        <?php } else { ?>

                    <h2><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h2>

                    <?php } ?>
                <div class="col-3 my-3">

                <?php

                while($row_cat = $sqlCaracter->fetch(PDO::FETCH_ASSOC)){
                    $idCat = $row_cat['idCat']; // caracteristicas disponibles
                    echo $row_cat['caracteristica'] . ": "; //caracteristica

                    echo "<select class='form-select' id='cat_$idCat'>";

                    $sqlDet = $con->prepare("SELECT id, valor, stock FROM de_pro_car WHERE id_producto=? AND 
                    id_caracteristica=?");
                    $sqlDet->execute([$id, $idCat]);
                    while($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)){
                        echo "<option id='" . $row_det['id'] . "'>".$row_det['valor']."</option>";
                    }

                    echo "</select>";
                }


                ?>


                </div>

                <div class="col-3 my-3">
                    Cantidad: <input class="form-control" id="cantidad" name="cantidad" type="number" min="1" max="10" value="1">
                </div>
                    <button class="normal" id="btnAgregar">Añadir al carrito</button>
                    <button class="normal">Comprar ahora</button>
                    <h4>Detalles</h4>
                    <span><?php echo $descripcion; ?></span>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>    
    <script>
    let btnAgregar = document.getElementById("btnAgregar");
    btnAgregar.addEventListener("click", function() {
        let inputCantidad = document.getElementById("cantidad").value;
        addProducto(<?php echo $id; ?>, inputCantidad, '<?php echo $token_tmp; ?>');
    });

    function addProducto(id, cantidad, token){
        let url = 'clases/carrito.php';
        let formData = new FormData();
        formData.append('id', id);
        formData.append('cantidad', cantidad);
        formData.append('token', token);

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors',
        }).then(response => response.json())
        .then(data => {
            if(data.ok){
                let elemento = document.getElementById("num_cart");
                elemento.innerHTML = data.numero;
            }
        });
    }
</script>

    </body>
    </html>