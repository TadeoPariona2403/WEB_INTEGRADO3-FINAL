<?php 

require_once '../config/database.php';
require_once 'clienteFunciones.php';

$datos = [];

if(isset($_POST['action'])){
    $action = $_POST['action'];

        $db = new Database();
        $con = $db->conectar();

    if($action == 'Userexiste'){
        $datos['ok'] = usuExists($_POST['usuario'], $con);
    } else if($action = 'emailExiste'){
        $datos['ok'] = emailExists($_POST['email'], $con);
    }
}

echo json_encode($datos);