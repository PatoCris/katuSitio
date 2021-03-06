<?php
header('Content-type: application/json');
error_reporting(E_ALL);
ini_set("display_errors", 1);
$accion = $_POST['accion'];
date_default_timezone_set("America/Buenos_Aires");
$fecha = date('Y-m-d');
include_once '../../php/Servicio.php';

function listaServicio() {
    $servicios = Servicio::traerServicios();
    echo json_encode($servicios);
}

switch ($accion) {
    case "nuevoServicio":
        include_once '../RedimensionarImg.php';
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $usuario = 1; 
        $codigo = $_POST['codigo'];
        
        if (!empty($codigo)) { 
            $servicioEdit = Servicio::buscarServicio($codigo); 
            if(!empty($_FILES['imagen']['name'])){
                $ic = "imagen_chica/".$servicioEdit->getImagen();
                $ig = "imagen_grande/".$servicioEdit->getImagen();
                unlink($ic);
                unlink($ig);
                /////////////////////IMAGEN/////////////////////////
                $imagenesTemNombre = $_FILES['imagen']['tmp_name'];
                $imagenesNombre = $_FILES['imagen']['name'];
                $imagenesTipo = $_FILES['imagen']['type'];
                $imagen = date("Y-m-d(H-i-s)").$imagenesNombre;
                $imagen_chica = "imagen_chica/" . $imagen;
                $imagen_chica = str_replace(' ', '', $imagen_chica); //eliminar espacios en blancos
                $imagen_grande = "imagen_grande/" . $imagen;
                $imagen_grande = str_replace(' ', '', $imagen_grande); //eliminar espacios en blancos

                move_uploaded_file($imagenesTemNombre, $imagen_grande);
                cambiartam($imagen_grande, $imagen_chica, 180, 180);
                $tam = getimagesize($imagen_grande);

                if ($tam[0] > 550 OR $tam[1] > 550) {
                    cambiartam($imagen_grande, $imagen_grande, 550, 550);
                }
                                
                $servicio = new Servicio($nombre, $descripcion, $fecha, $usuario, $imagen, $codigo);
                $servicio->guardarServicio();
            }else{
                $servicio = new Servicio($nombre, $descripcion, $fecha, $usuario, $servicioEdit->getImagen(), $codigo);
                $servicio->guardarServicio();
            }

        }else{
        /////////////////////IMAGEN/////////////////////////
            $imagenesTemNombre = $_FILES['imagen']['tmp_name'];
            $imagenesNombre = $_FILES['imagen']['name'];
            $imagenesTipo = $_FILES['imagen']['type'];
            $imagen = date("Y-m-d(H-i-s)").$imagenesNombre;
            $imagen_chica = "imagen_chica/" . $imagen;
            $imagen_chica = str_replace(' ', '', $imagen_chica); //eliminar espacios en blancos
            $imagen_grande = "imagen_grande/" . $imagen;
            $imagen_grande = str_replace(' ', '', $imagen_grande); //eliminar espacios en blancos

            move_uploaded_file($imagenesTemNombre, $imagen_grande);
            cambiartam($imagen_grande, $imagen_chica, 180, 180);
            $tam = getimagesize($imagen_grande);

            if ($tam[0] > 550 OR $tam[1] > 550) {
                cambiartam($imagen_grande, $imagen_grande, 550, 550);
            }
            $servicio = new Servicio($nombre, $descripcion, $fecha, $usuario, $imagen);
            $servicio->guardarServicio();
        }
        listaServicio();    
        break;
    case "eliminarServicio":
        $codigo = $_POST['codigo'];
        Servicio::borrarServicio($codigo);
        listaServicio();
        break;
    case "traerServicios":
        listaServicio();
        break;
    case "buscarServicios":
        $busqueda = $_POST['buscar'];
        $result = Servicio::buscarServicios($busqueda);
        echo json_encode($result);
        break;
}
?>