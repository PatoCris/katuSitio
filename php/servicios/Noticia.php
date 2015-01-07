<?php

header('Content-type: application/json');
error_reporting(E_ALL);
ini_set("display_errors", 1);
$accion = $_POST['accion'];
date_default_timezone_set("America/Buenos_Aires");
$fecha = date('Y-m-d');
include_once '../../php/Noticia.php';

function listaNoticia() {
    $noticias = Noticia::traerNoticias();
    echo json_encode($noticias);
}

switch ($accion) {
    case "nuevaNoticia":
        include_once '../RedimensionarImg.php';
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['contenido'];
        $usuario = 1; 
        $codigo = $_POST['codigo'];
        
        if (!empty($codigo)) { 
            $noticiaEdit = Noticia::buscarNoticia($codigo); 
            if(!empty($_FILES['imagen']['name'])){
                $ic = "imagen_chica/".$noticiaEdit->getImagen();
                $ig = "imagen_grande/".$noticiaEdit->getImagen();
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
                                
                $noticia = new Noticia($nombre, $descripcion, $fecha, $usuario, $imagen, $codigo);
                $noticia->guardarNoticia();
            }else{
                $noticia = new Noticia($nombre, $descripcion, $fecha, $usuario, $noticiaEdit->getImagen(), $codigo);
                $noticia->guardarNoticia();
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
            $noticia = new Noticia($nombre, $cuerpo, $fecha, $usuario, $imagenMiniatura, $codigo);
            $noticia->guardarNoticia();
            
        }
        listaNoticia();    
        break;
    case "eliminarNoticia":
        $codigo = $_POST['codigo'];
        Noticia::borrarNoticia($codigo);
        listaNoticia();
        break;
    case "traerNoticia":
        listaNoticia();
        break;
    case "buscarNoticia":
        $busqueda = $_POST['buscar'];
        $result = Noticia::buscarNoticias($busqueda);
        echo json_encode($result);
        break;
}
?>

