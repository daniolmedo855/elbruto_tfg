<?php
    class BD{
        protected $bd;

        public function __construct(){
            $this->bd = new mysqli("localhost", "root", "", "elbruto");
        }

        public function __get($nombre){
            return $this->$nombre;
        }

        public function __set($nombre, $valor){
            $this->$nombre = $valor;
        }

        public function cerrar(){
            $this->bd->close();
        }
    }
?>