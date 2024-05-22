<?php
require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';
$db = new Database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {

    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $dni = trim($_POST['dni']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if (esincorrecto([$nombres, $apellidos, $email, $telefono, $dni, $usuario, $password, $repassword], $con)) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!esEmail($email)) {
        $errors[] = "La direccion de correo es invalida";
    }

    if (!validaContrasena($password, $repassword)) {
        $errors[] = "Las contrasenas no coinciden";
    }

    if (usuExists($usuario, $con)) {
        $errors[] = "El nombre de usuario $usuario ya existe";
    }

    if (emailExists($email, $con)) {
        $errors[] = "El correo $email ya existe";
    }

    if (count($errors) == 0) {
        $id = registraCliente([$nombres, $apellidos, $email, $telefono, $dni], $con);

        if ($id > 0) {
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $token = generarToken();
            if (!registraUsuario([$usuario, $pass_hash, $token, $id], $con)) {
                $errors[] = 'Error al registrar usuario';
            }
        } else {
            $errors[] = 'Error al registrar cliente';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

<header>
      <div>
        <a href="/">CORPORACION MILO</a>
      </div>
</header>

<main>
        <div class="container">
            <h2>Datos del cliente: </h2>

            <?php mostrarMensajes($errors); ?>

            <form class="row g-3" action="register.php" method="post" autocomplete="off">
                <div class="col-md-6">
                    <label for="nombres"><span class="text-danger">*</span>Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="apellidos"><span class="text-danger">*</span>Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="email"><span class="text-danger">*</span>Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <span id="validarEmail" class="text-danger"></span>
                </div>
                <div class="col-md-6">
                    <label for="telefono"><span class="text-danger">*</span>Telefono</label>
                    <input type="tel" name="telefono" id="telefono" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="dni"><span class="text-danger">*</span>DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="usuario"><span class="text-danger">*</span>Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" required>
                    <span id="validarUsu" class="text-danger"></span>
                </div>
                <div class="col-md-6">
                    <label for="password"><span class="text-danger">*</span>Contrasena</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="repassword"><span class="text-danger">*</span>Repetir contrasena</label>
                    <input type="password" name="repassword" id="repassword" class="form-control" required>
                </div>

                <i><b>Ojo: Los campos(*) son obligatorios</b></i>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>
        </div>
    </main>

    <a href="#" class="arrow"><i><img src="./images/imagenes/arrow.png" alt=""></i></a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
    let txtUsuario = document.getElementById('usuario')
    txtUsuario.addEventListener("blur", function(){
        Userexiste(txtUsuario.value)
    }, false)

    

    function Userexiste(usuario){
        let url = "clases/clientAjax.php"
        let formData = new FormData()
        formData.append("action", "Userexiste")
        formData.append("usuario", usuario)

        fetch(url, {
            method: 'POST', 
            body: formData
        }).then(response => response.json())
        .then(data => {
            
            if(data.ok){
                document.getElementById('usuario').value = ''
                document.getElementById('validarUsu').innerHTML = 'Ya existe este nombre de usuario'
            } else {
                document.getElementById('validarUsu').innerHTML = ''
            }

        })

    }

    let txtEmail = document.getElementById('email')
    txtEmail.addEventListener("blur", function(){
        Emailexiste(txtEmail.value)
    }, false)

    function Emailexiste(email){
        let url = "clases/clientAjax.php"
        let formData = new FormData()
        formData.append("action", "Emailexiste")
        formData.append("email", email)

        fetch(url, {
            method: 'POST', 
            body: formData
        }).then(response => response.json())
        .then(data => {
            
            if(data.ok){
                document.getElementById('email').value = ''
                document.getElementById('validarEmail').innerHTML = 'Este email ya esta registrado'
            } else {
                document.getElementById('validarEmail').innerHTML = ''
            }

        })

    }
</script>

</body>
</html>

