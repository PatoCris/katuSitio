<?php
class Testimonio {
    private $codigo;    
    private $descripcion;
    
    function __construct($codigo, $descripcion) {
        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function guardarTestimonio() {
        
    }
    public function modificarTestimonio() {
        
    }

}
