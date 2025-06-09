<?php
    require_once "bd.php";

    class Efecto extends BD{
        protected $id_efecto;
        protected $nombre;

        public function __construct($id_efecto=null, $nombre=null){
            parent::__construct();
            $this->id_efecto = $id_efecto;
            $this->nombre = $nombre;
        }
    }
?>