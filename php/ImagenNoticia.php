<?php
include_once __DIR__.'/Conexion.php';

/**
 * Description of Imagen
 *
 * @author cristian
 */
class ImagenNoticia {
    private $codigo;
    private $ruta;
    private $noticia;
    const TABLA = 'imagenes_noticias';
        
    function __construct($ruta, $noticia, $codigo = null) {
        $this->codigo = $codigo;
        $this->ruta = $ruta;
        $this->noticia = $noticia;
    }
    
    public function getCodigo() {
        return $this->codigo;
    }

    public function getRuta() {
        return $this->ruta;
    }

    public function getNoticia() {
        return $this->noticia;
    }

    public function setRuta($ruta) {
        $this->ruta = $ruta;
    }

    public function setNoticia($noticia) {
        $this->noticia = $noticia;
    }

    public function guardarImagenNoticia(){
        $conexion = new Conexion();
        if($this->codigo)/*Editar Registro*/ {
            $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET ruta = :ruta, noticia = :noticia WHERE codigo = :codigo');
            $consulta->bindParam(':ruta', $this->ruta);
            $consulta->bindParam(':noticia', $this->noticia);
            $consulta->bindParam(':codigo', $this->codigo);
            $consulta->execute();
        }else /*Nuevo Objeto*/{
            $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' (ruta, noticia) VALUES (:ruta, :noticia)');
            $consulta->bindParam(':ruta', $this->ruta);
            $consulta->bindParam(':noticia', $this->noticia);
            $consulta->execute();
            $this->codigo = $conexion->lastInsertId();
        }
        $conexion = null;
    }
    public static function borrarImagen($codigo){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA .' WHERE codigo = :codigo');
        $consulta->bindParam(':codigo', $codigo);
        $consulta->execute();
        $conexion = null;
    }
    public static function buscarImagen($codigo){
       $conexion = new Conexion();
       $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE codigo = :codigo');
       $consulta->bindParam(':codigo', $codigo);
       $consulta->execute();
       $registro = $consulta->fetch();
       if($registro){
          return new self($registro['ruta'], $registro['noticia'], $registro['codigo']);
       }else{
          return false;
       }
    }
    public static function traerImagenXNoticia($noticia) {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE noticia = :noticia ORDER BY codigo DESC');
        $consulta->bindParam(':noticia', $noticia);
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }
    
}
