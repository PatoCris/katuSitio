<?php
header('Content-type: application/json');
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once __DIR__.'/Conexion.php';

if(isset($_POST['enviar'])){
    if(empty($_POST['usuario'])  || empty($_POST['clave'])){
        echo 'Debe completar todos los campos.';
    }else{
        $nombreUsuario = $_POST['usuario'];
        $claveUsuario = $_POST['clave'];
        $claveUsuario = crypt($claveUsuario, '$2a$07$yMoJrJpwEPrmVnZx4KIyNuOAiOMQksjkV1EW0YRgVe33eYe/yT60y');
        require_once './Usuario.php';
        $registro = Usuario::comprobarUsuario($nombreUsuario, $claveUsuario);
        if($registro){
            $_SESSION['usuario'] = $registro->getNombreUsuario();
            $_SESSION['nivel'] = $registro->getNivel();
            header('Location: ../GestionGeneral.php');
        }else{
            header('Location: ../acceso.html');
        }
    }
    
}else{
   echo 'No se enviaron datos.';
}

?>
