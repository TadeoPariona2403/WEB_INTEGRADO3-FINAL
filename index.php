<?php

require 'config/config.php';
require 'config/database.php';

print_r($_SESSION);

$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

//session_destroy();

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
            <a href="uilogin.php"><img src="./images/imagenes/register.png" alt="" width="18px">LOGIN</a>
            <a href="uilogin.php"><img src="./images/imagenes/register.png" alt="" width="18px">REGISTER</a>
        </div>
</div>

<?php include 'header.php'; ?>

      <section class="home">
        <div class="content">
        <h1><span>Productos</span>
            <br>
            Hasta <span id="span2">50%</span> de descuento
        </h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        <div class="btn"><button>Comprar</button></div>
      </div>
      <div class="img">
        <img src="./images/imagenes/banner.png" alt="">
      </div>
      
    </section>



    <div class="container" id="product-cards">
    <h1 class="text-center">PRODUCTOS</h1>
    <div class="row" style="margin-top: 30px;">
        <?php foreach ($resultado as $producto) { ?>
            <div class="col-md-3 py-3 py-md-0">
                <div class="card">
                    <?php
                        $imagen = "images/productos/" . $producto['id'] . "/principal.png";
                        if (!file_exists($imagen)) {
                            $imagen = "images/no-photo.png";
                        }
                    ?>
                    <a href="details.php?id=<?php echo $producto['id'] ?>&token=<?php echo hash_hmac('sha1', $producto['id'], KEY_TOKEN); ?>"><img src="<?php echo $imagen; ?>" class="d-block w-100" alt=""></a>
                    <div class="card-body">
                        <h3 class="text-center"><?php echo $producto['nombre']; ?></h3>
                        <div class="star text-center">
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h2>S/<?php echo number_format($producto['precio'], 2, '.', ',') ; ?></h2>
                            <button type="button" class="btn btn-primary" onclick="addProducto(<?php echo $producto['id']; ?>, 
                            '<?php echo hash_hmac('sha1', $producto['id'], KEY_TOKEN); ?>')">Agregar <i class="fa-solid fa-cart-shopping"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>





            


    <div class="container" id="other-cards">
        <div class="row">
            <div class="col-md-6 py-3 py-md-0">
                <div class="card">
                    <img src="./images/imagenes/ram2.png" alt="">
                    <div class="card-img-overlay">
                        <h3>Memoria ram DDR4</h3>
                        <h5>Lorem ipsum</h5>
                        <p>Hasta 60% de descuento</p>
                        <button id="shopnow">Comprar</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 py-3 py-md-0">
                <div class="card">
                    <img src="./images/imagenes/ram.png" alt="">
                    <div class="card-img-overlay">
                        <h3>Memoria ram DDR4</h3>
                        <h5>Lorem ipsum</h5>
                        <p>Hasta 60% de descuento</p>
                        <button id="shopnow">Comprar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="banner">
        <div class="content">
        <h1><span>Productos</span>
            <br>
            Hasta <span id="span2">50%</span> de descuento
        </h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        <div class="btn"><button>Comprar</button></div>
      </div>
      <div class="img">
        <img src="./images/imagenes/banner.png" alt="">
      </div>
    </section>


    
      <div class="container" id="product-cards">
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-3 py-3 py-md-0">
                <div class="card">
                    <img src="./images/imagenes/pr7.png" alt="">
                    <div class="card-body">
                        <h3 class="text-center">Lorem</h3>
                        <p class="text-center">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                        <div class="star text-center">
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                        </div>
                        <h2>S/1000<span><i class="fa-solid fa-cart-shopping"></i></span></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 py-3 py-md-0">
                <div class="card">
                    <img src="./images/imagenes/pr7.png" alt="">
                    <div class="card-body">
                        <h3 class="text-center">Lorem</h3>
                        <p class="text-center">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                        <div class="star text-center">
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                        </div>
                        <h2>S/1000<span><i class="fa-solid fa-cart-shopping"></i></span></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 py-3 py-md-0">
                <div class="card">
                    <img src="./images/imagenes/pr7.png" alt="">
                    <div class="card-body">
                        <h3 class="text-center">Lorem</h3>
                        <p class="text-center">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                        <div class="star text-center">
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                        </div>
                        <h2>S/1000<span><i class="fa-solid fa-cart-shopping"></i></span></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 py-3 py-md-0">
                <div class="card">
                    <img src="./images/imagenes/pr7.png" alt="">
                    <div class="card-body">
                        <h3 class="text-center">Lorem</h3>
                        <p class="text-center">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                        <div class="star text-center">
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                            <i class="fa-solid fa-star checked"></i>
                        </div>
                        <h2>S/1000<span><i class="fa-solid fa-cart-shopping"></i></span></h2>
                    </div>
                </div>
            </div>
      </div>



      <div class="container" id="other">
        <div class="row">
            <div class="col-md-4 py-3 py-md-0">
                <div class="card">
                    <img src="./images/imagenes/c3.png" alt="">
                    <div class="card-img-overlay">
                        <h3>lorem</h3>
                        <p>lorem</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 py-3 py-md-0">
                <div class="card">
                    <img src="./images/imagenes/c3.png" alt="">
                    <div class="card-img-overlay">
                        <h3>lorem</h3>
                        <p>lorem</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 py-3 py-md-0">
                <div class="card">
                    <img src="./images/imagenes/c3.png" alt="">
                    <div class="card-img-overlay">
                        <h3>lorem</h3>
                        <p>lorem</p>
                    </div>
                </div>
            </div>
        </div>
      </div>



      <div class="container" id="offer">
        <div class="row">
            <div class="col-md-3 py-3 py-md-0">
                <i class="fa-solid fa-cart-shopping"></i>
                <h3>lore</h3>
                <p>lore</p>
            </div>
            <div class="col-md-3 py-3 py-md-0">
                <i class="fa-solid fa-cart-shopping"></i>
                <h3>lore</h3>
                <p>lore</p>
            </div>
            <div class="col-md-3 py-3 py-md-0">
                <i class="fa-solid fa-cart-shopping"></i>
                <h3>lore</h3>
                <p>lore</p>
            </div>
            <div class="col-md-3 py-3 py-md-0">
                <i class="fa-solid fa-cart-shopping"></i>
                <h3>lore</h3>
                <p>lore</p>
            </div>
        </div>
      </div>

      

      <div class="container" id="newslater">
        <h3 class="text-center">lorem</h3>
        <div class="input text-center">
            <input type="text" placeholder="ingresa tu">
            <button id="subscribe">Suscribete</button>
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
        function addProducto(id, token){
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors',
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })
        }
    </script>
</body>
</html>