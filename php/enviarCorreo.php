<?php
require_once './Util.php';
$nombre = $_POST['nombre'];
$correo = $_POST['email'];
$telefono = $_POST['telefono'];
$mensaje = $_POST['mensaje'];

Util::correoContacto($nombre, $mensaje, $telefono, $correo);

echo '<p style="color: #f60; font-size: 14px">Su mensaje ha sido enviado correctamente. </p>';
echo '<a href="http://www.katupyry.misiones.org.ar">volver</a>';