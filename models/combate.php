<?php
    require_once "bd.php";

    class Combate extends BD{
        protected $id_combate;
        protected $fecha;
        protected $id_ganador;
        protected $id_perdedor;

        public function __construct($id_combate=null, $fecha=null, $id_ganador=null, $id_perdedor=null){
            parent::__construct();
            $this->id_combate = $id_combate;
            $this->fecha = $fecha;
            $this->id_ganador = $id_ganador;
            $this->id_perdedor = $id_perdedor;
        }
    }
?>