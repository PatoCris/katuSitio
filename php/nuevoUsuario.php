<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once 'Usuario.php';

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$fechaNacimiento = $_POST['fechaNacimiento'];
$correo = $_POST['correo'];
$nombreUsuario = $_POST['nombreUsuario'];
$clave = $_POST['clave'];
$nivel = $_POST['nivel'];


if (isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];
    $miUsuario = new Usuario($nombre, $apellido, $fechaNacimiento, $nombreUsuario, $clave, $correo, $nivel, $codigo);
    $miUsuario->guardarUsuario();
} else {
    $clave = crypt($clave, '$2a$07$yMoJrJpwEPrmVnZx4KIyNuOAiOMQksjkV1EW0YRgVe33eYe/yT60y');

    $miUsuario = new Usuario($nombre, $apellido, $fechaNacimiento, $nombreUsuario, $clave, $correo, $nivel);
    $miUsuario->guardarUsuario();
}


