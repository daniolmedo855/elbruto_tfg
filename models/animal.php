<?php
    require_once "bd.php";

    class Animal extends BD {
        protected $id_animal;
        protected $nombre;
        protected $danio;
        protected $imagen;

        public function __construct($id_animal=null, $nombre=null, $danio=null, $imagen=null) {
            parent::__construct();
            $this->id_animal = $id_animal;
            $this->nombre = $nombre;
            $this->danio = $danio;
            $this->imagen = $imagen;
        }

        public function get_animales_bruto($id_bruto) {
            $sql = "SELECT imagen from animal where id_animal in (select id_animal from bruto_animal where id_bruto = ?)";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }

        function get_id_animales(){
            $sql = "SELECT id_animal FROM animal";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $animales = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $animales;
        }
    }
?>