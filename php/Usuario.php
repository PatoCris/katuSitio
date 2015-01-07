<?php
include_once __DIR__.'/Conexion.php';

class Usuario {
    private $codigo;
    private $nombre;
    private $apellido;
    private $nombreUsuario;
    private $clave;
    private $correo;
    private $nivel;
    const TABLA = 'usuarios';
    
    function __construct($nombre, $apellido, $nombreUsuario, $clave, $correo, $nivel, $codigo = null) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->nombreUsuario = $nombreUsuario;
        $this->clave = $clave;
        $this->correo = $correo;
        $this->nivel = $nivel;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }
    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }
    public function getNivel() {
        return $this->nivel;
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

        
public function guardarUsuario(){
    $conexion = new Conexion();
    if($this->codigo) /*Modifica*/ {
        $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET nombre = :nombre, apellido = :apellido, nombreUsuario = :nombreUsuario, clave = :clave, correo = :correo, nivel = :nivel WHERE codigo = :codigo');
        $consulta->bindParam(':nombre', $this->nombre);
        $consulta->bindParam(':apellido', $this->apellido);
        $consulta->bindParam(':nombreUsuario', $this->nombreUsuario);
        $consulta->bindParam(':clave', $this->clave);
        $consulta->bindParam(':correo', $this->correo);
        $consulta->bindParam(':nivel', $this->nivel);
        $consulta->bindParam(':codigo', $this->codigo);
        $consulta->execute();
      }else /*Inserta*/ {
        $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA . ' (nombre, apellido, nombreUsuario, clave, correo, nivel) VALUES (:nombre, :apellido, :nombreUsuario, :clave, :correo, :nivel)');
        $consulta->bindParam(':nombre', $this->nombre);
        $consulta->bindParam(':apellido', $this->apellido);
        $consulta->bindParam(':nombreUsuario', $this->nombreUsuario);
        $consulta->bindParam(':clave', $this->clave);
        $consulta->bindParam(':correo', $this->correo);
        $consulta->bindParam(':nivel', $this->nivel);
        $consulta->execute();
        $this->codigo = $conexion->lastInsertId();
      }
      $conexion = null;
}
public function borrarUsuario($codigo) {
    $conexion = new Conexion();
    $consulta = $conexion->prepare('DELETE from ' . self::TABLA . ' WHERE codigo = :codigo');
    $consulta->bindParam(':codigo', $codigo);
    $consulta->execute();
    $this->codigo = $conexion ->lastInsertId();
}

    public static function buscarUsuario($codigo){
       $conexion = new Conexion();
       $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE codigo = :codigo');
       $consulta->bindParam(':codigo', $codigo);
       $consulta->execute();
       $registro = $consulta->fetch();
       if($registro){
          return new self($registro['nombre'], $registro['apellido'], $registro['nombreUsuario'], $registro['clave'], $registro['correo'], $registro['nivel'], $registro['codigo']);
       }else{
          return false;
       }
    }

    public static function comprobarUsuario($nombreUsuario, $claveUsuario){
       $conexion = new Conexion();
       $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE nombreUsuario = :usuario AND clave = :clave');
       $consulta->bindParam(':usuario', $nombreUsuario);
       $consulta->bindParam(':clave', $claveUsuario);
       $consulta->execute();
       $registro = $consulta->fetch();
       if($registro){
       return new self($registro['nombre'], $registro['apellido'], $registro['nombreUsuario'], $registro['clave'], $registro['correo'], $registro['nivel'], $registro['codigo']);
       }else{
          return false;
       }
    }
    
    public static function traerUsuarios() {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY codigo DESC');
        $consulta->execute();
        $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    
    public static function buscarUsuarios($busqueda) {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE nombre LIKE "%'.$busqueda.'%" ORDER BY codigo DESC');
        $consulta->execute();
        $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    
}

