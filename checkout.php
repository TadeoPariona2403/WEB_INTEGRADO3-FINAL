<?php

require 'config/config.php';
require 'config/database.php';
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
}



//session_destroy();

//print_r($_SESSION);

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

<main>
        <div class="container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($lista_carrito == null){
                            echo '<tr><td colspan="5" class="text-center"><b>Lista vacía</b></td></tr>';
                        } else {
                            $total = 0;
                            foreach($lista_carrito as $producto){
                                $_id = $producto[0]['id'];
                                $nombre = $producto[0]['nombre'];
                                $precio = $producto[0]['precio'];
                                $descuento = $producto[0]['descuento'];
                                $cantidad = $producto[0]['cantidad'];
                                $precio_desc = $precio - (($precio * $descuento) / 100);
                                $subtotal = $cantidad * $precio_desc;
                                $total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo $nombre; ?></td>
                            <td><?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?></td>
                            <td>
                                <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad; ?>"
                                size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id ?>)"> 
                            </td>
                            <td>
                                <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . 
                                number_format($subtotal, 2, '.', ','); ?></div>
                            </td>
                            <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo
                            $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Descartar</a></td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">
                                <p class="h3" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                            </td>
                        </tr>

                    </tbody>
                    <?php } ?>
                </table>
            </div>

            <?php if($lista_carrito != null){ ?>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                <?php if(isset($_SESSION['user_cliente'])){ ?>
                    <a href="pago.php" class="btn btn-primary btn-lg">Comprar</a>
                <?php } else { ?>
                    <a href="login.php?pago" class="btn btn-primary btn-lg">Comprar</a>
                <?php } ?>
                </div>
            </div>
        </div>
            <?php } ?>
        
</main>

        <!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="eliminaModalLabel">Advertencia</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Esta a punto de eliminar el producto
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Descartar</button>
      </div>
    </div>
  </div>
</div>


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

   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>    
<script>

    let eliminaModal = document.getElementById('eliminaModal')
    eliminaModal.addEventListener('show.bs.modal', function(event){
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
        buttonElimina.value = id
    })

    function eliminar(){

        let botonElimina = document.getElementById('btn-elimina')
        let id = botonElimina.value

        let url = 'clases/actualizar_carrito.php';
        let formData = new FormData();
        formData.append('action', 'eliminar');
        formData.append('id', id);

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors',
        }).then(response => response.json())
        .then(data => {
            if(data.ok){
                location.reload()
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    }

    function actualizaCantidad(cantidad, id){
        let url = 'clases/actualizar_carrito.php';
        let formData = new FormData();
        formData.append('action', 'agregar');
        formData.append('id', id);
        formData.append('cantidad', cantidad);

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors',
        }).then(response => response.json())
        .then(data => {
            if(data.ok){
                let divsubtotal = document.getElementById('subtotal_' + id);
                divsubtotal.innerHTML = data.sub;

                let total = 0.00;
                let list = document.getElementsByName('subtotal[]');

                for(let i = 0; i < list.length; i++){
                    total += parseFloat(list[i].innerHTML.replace(/[^0-9.]/g, ''));
                }

                total = new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2
                }).format(total)

                document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total;
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    }

    
</script>


</body>
</html>