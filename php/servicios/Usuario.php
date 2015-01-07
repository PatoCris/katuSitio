<?php

header('Content-type: application/json');
error_reporting(E_ALL);
ini_set("display_errors", 1);
$accion = $_POST['accion'];
date_default_timezone_set("America/Buenos_Aires");
$fecha = date('Y-m-d');
include_once '../../php/Usuario.php';

function listaUsuario() {
    $usuarios = Usuario::traerUsuarios();
    echo json_encode($usuarios);
}

switch ($accion) {
    case "nuevoUsuario":
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $nombreUsuario = $_POST['nombreUsuario'];
        $clave = $_POST['clave'];
        $correo = $_POST['correo'];
        $nivel = $_POST['nivel'];
        $codigo = $_POST['codigo'];

        if (!empty($codigo)) {
            if(!empty($clave)){
                $claveIncrip = crypt($clave, '$2a$07$yMoJrJpwEPrmVnZx4KIyNuOAiOMQksjkV1EW0YRgVe33eYe/yT60y');
                $usuario = new Usuario($nombre, $apellido, $nombreUsuario, $claveIncrip, $correo, $nivel, $codigo);
            }else{
                $Unusuario = Usuario::buscarUsuario($codigo);
                $usuario = new Usuario($nombre, $apellido, $nombreUsuario, $Unusuario->getClave(), $correo, $nivel, $codigo);
            }
            
            $usuario->guardarUsuario();
        } else {
            $claveIncrip = crypt($clave, '$2a$07$yMoJrJpwEPrmVnZx4KIyNuOAiOMQksjkV1EW0YRgVe33eYe/yT60y');
            $usuario = new Usuario($nombre, $apellido, $nombreUsuario, $claveIncrip, $correo, $nivel);
            $usuario->guardarUsuario();
        }
        listaUsuario();
        break;
    case "eliminarUsuario":
        $codigo = $_POST['codigo'];
        Usuario::borrarUsuario($codigo);
        listaUsuario();
        break;
    case "traerUsuarios":
        listaUsuario();
        break;
    case "buscarUsuarios":
        $busqueda = $_POST['buscar'];
        $result = Usuario::buscarUsuarios($busqueda);
        echo json_encode($result);
        break;
}
?>
