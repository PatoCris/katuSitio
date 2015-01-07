<?php
include_once __DIR__.'/Conexion.php';

class Servicio {
    private $codigo;
    private $nombre;
    private $descripcion;
    private $fecha;
    private $usuario;
    private $imagen;
    const TABLA = 'servicios';
        
    function __construct($nombre, $descripcion, $fecha, $usuario, $imagen, $codigo = null) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->usuario = $usuario;
        $this->imagen = $imagen;
    }
    
    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function guardarServicio(){
        $conexion = new Conexion();
        if($this->codigo)/*Editar Registro*/ {
            $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET nombre = :nombre, descripcion = :descripcion, fecha = :fecha, usuario = :usuario, imagen = :imagen WHERE codigo = :codigo');
            $consulta->bindParam(':nombre', $this->nombre);
            $consulta->bindParam(':descripcion', $this->descripcion);
            $consulta->bindParam(':fecha', $this->fecha);
            $consulta->bindParam(':usuario', $this->usuario);
            $consulta->bindParam(':imagen', $this->imagen);
            $consulta->bindParam(':codigo', $this->codigo);
            $consulta->execute();
        }else /*Nuevo Objeto*/{
            $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' (nombre, descripcion, fecha, usuario, imagen) VALUES (:nombre, :descripcion, :fecha, :usuario, :imagen)');
            $consulta->bindParam(':nombre', $this->nombre);
            $consulta->bindParam(':descripcion', $this->descripcion);
            $consulta->bindParam(':fecha', $this->fecha);
            $consulta->bindParam(':usuario', $this->usuario);
            $consulta->bindParam(':imagen', $this->imagen);
            $consulta->execute();
            $this->codigo = $conexion->lastInsertId();
        }
        $conexion = null;
    }
    
    public static function borrarServicio($codigo){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA .' WHERE codigo = :codigo');
        $consulta->bindParam(':codigo', $codigo);
        $consulta->execute();
        $conexion = null;
    }
    public static function buscarServicio($codigo){
       $conexion = new Conexion();
       $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE codigo = :codigo');
       $consulta->bindParam(':codigo', $codigo);
       $consulta->execute();
       $registro = $consulta->fetch();
       if($registro){
          return new self($registro['nombre'], $registro['descripcion'], $registro['fecha'], $registro['usuario'], $registro['imagen'], $registro['codigo']);
       }else{
          return false;
       }
    }
    public static function traerServicios() {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY codigo DESC');
        $consulta->execute();
        $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    
    public static function buscarServicios($busqueda) {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE nombre LIKE "%'.$busqueda.'%" OR descripcion LIKE "%'.$busqueda.'%" ORDER BY codigo DESC');
        $consulta->execute();
        $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    
    
    
    
}
