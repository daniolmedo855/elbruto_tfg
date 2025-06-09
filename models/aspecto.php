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
    }
?>