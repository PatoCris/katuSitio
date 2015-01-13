<?PHP
include_once __DIR__.'/Conexion.php';

class Noticia {
    private $codigo;
    private $nombre;
    private $cuerpo;
    private $fecha;
    private $usuario;
    private $imagenMiniatura;
    const TABLA = 'noticias';
    
    function __construct($nombre, $cuerpo, $fecha, $usuario, $imagenMiniatura, $codigo = null) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->cuerpo = $cuerpo;
        $this->fecha = $fecha;
        $this->usuario = $usuario;
        $this->imagenMiniatura = $imagenMiniatura;
    }
    
    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCuerpo() {
        return $this->cuerpo;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getImagenMiniatura() {
        return $this->imagenMiniatura;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setCuerpo($cuerpo) {
        $this->cuerpo = $cuerpo;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setImagenMiniatura($imagenMiniatura) {
        $this->imagenMiniatura = $imagenMiniatura;
    }

   public function guardarNoticia (){
        $conexion = new Conexion();
        if($this->codigo)/*Editar Registro*/ {
            $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET nombre = :nombre, cuerpo = :cuerpo, fecha = :fecha, usuario = :usuario, imagenMiniatura = :imagenMiniatura WHERE codigo = :codigo');
            $consulta->bindParam(':nombre', $this->nombre);
            $consulta->bindParam(':cuerpo', $this->cuerpo);
            $consulta->bindParam(':fecha', $this->fecha);
            $consulta->bindParam(':usuario', $this->usuario);
            $consulta->bindParam(':imagenMiniatura', $this->imagenMiniatura);
            $consulta->bindParam(':codigo', $this->codigo);
            $consulta->execute();
        }else /*Nuevo Objeto*/{
            $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' (nombre, cuerpo, fecha, usuario, imagenMiniatura) VALUES (:nombre, :cuerpo, :fecha, :usuario, :imagenMiniatura)');
            $consulta->bindParam(':nombre', $this->nombre);
            $consulta->bindParam(':cuerpo', $this->cuerpo);
            $consulta->bindParam(':fecha', $this->fecha);
            $consulta->bindParam(':usuario', $this->usuario);
            $consulta->bindParam(':imagenMiniatura', $this->imagenMiniatura);
            $consulta->execute();
            $this->codigo = $conexion->lastInsertId();
        }
        $conexion = null;
    }
    
    public static function borrarNoticia($codigo){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA .' WHERE codigo = :codigo');
        $consulta->bindParam(':codigo', $codigo);
        $consulta->execute();
        $conexion = null;
    }
    public static function buscarNoticia($codigo){
       $conexion = new Conexion();
       $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE codigo = :codigo');
       $consulta->bindParam(':codigo', $codigo);
       $consulta->execute();
       $registro = $consulta->fetch();
       if($registro){
          return new self($registro['nombre'], $registro['cuerpo'], $registro['fecha'], $registro['usuario'], $registro['imagenMiniatura'], $registro['codigo']);
       }else{
          return false;
       }
    }
    public static function traerNoticias() {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY codigo DESC');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }
    
    public static function buscarNoticias($busqueda) {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE nombre LIKE "%'.$busqueda.'%" ORDER BY codigo DESC');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        return $registros;
    }
}