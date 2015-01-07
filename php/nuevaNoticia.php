<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once './Noticia.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

date_default_timezone_set("America/Buenos_Aires");
$fecha = date('Y-m-d');
$nombre = $_POST['nombre'];
$cuerpo = $_POST['cuerpo'];
$usuario = 1;//$_POST['usuario'];
////////////////////////////////
$imagenMiniatura = "sdasdasd";

if(isset($_POST['codigo'])){
    $codigo = $_POST['codigo'];
    $noticia = new Noticia($nombre, $cuerpo, $fecha, $usuario, $imagenMiniatura, $codigo);
    $noticia->guardarNoticia();
    //header('Location: ../listaCampania.php');
}else{
    $noticia = new Noticia($nombre, $cuerpo, $fecha, $usuario, $imagenMiniatura);
    $noticia->guardarNoticia();
    //header('Location: ../listaCampania.php');
}

