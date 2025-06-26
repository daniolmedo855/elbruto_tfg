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

        public function get_animales_id($id_bruto){
            $sql = "SELECT * FROM animal where id_animal in (select id_animal from bruto_animal where id_bruto = ?);";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $animales = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $animales;
        }

        public function get_id_animales(){
            $sql = "SELECT id_animal FROM animal";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $animales = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $animales;
        }

        public function animal_random($id_bruto){
            $sql = "select id_animal from animal where id_animal not in (select id_animal from bruto_animal where id_bruto = ?) order by rand() limit 1;";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $animal = $resultado->fetch_all(MYSQLI_ASSOC);
            $sentencia->close();

            $sql = "insert into bruto_animal (id_bruto, id_animal) values (?, ?);";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("ii", $id_bruto, $animal[0]["id_animal"]);
            $sentencia->execute();

            return ["success" => true, "animal" => $animal[0]["id_animal"]];        
        }


        public function get_animales_all() {
            $sql = "select * from animal;";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $animal = $resultado->fetch_all(MYSQLI_ASSOC);
            $sentencia->close();
            return $animal;
        }
    }
?>