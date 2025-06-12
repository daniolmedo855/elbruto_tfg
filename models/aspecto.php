<?php
    require_once "bd.php";

    class Aspecto extends BD{
        protected $id_aspecto;
        protected $imagen;

        public function __construct($id_aspecto=null, $imagen=null){
            parent::__construct();
            $this->id_aspecto = $id_aspecto;
            $this->imagen = $imagen;
        }

        public function get_aspectos(){
            $sql = "select * from aspecto";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $aspectos = $resultado->fetch_all(MYSQLI_ASSOC);
            $sentencia->close();
            return $aspectos;
        }
    }
?>