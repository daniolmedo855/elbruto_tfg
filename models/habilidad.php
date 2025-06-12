<?php
    require_once "bd.php";

    class Habilidad extends BD{
        protected $id_habilidad;
        protected $nombre;
        protected $descripcion;
        protected $imagen;

        public function __construct($id_habilidad=null, $nombre=null, $descripcion=null, $imagen=null){
            parent::__construct();
            $this->id_habilidad = $id_habilidad;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->imagen = $imagen;
        }

        public function get_habilidades() {
            $sql = "SELECT * FROM habilidad";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $habilidades = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $habilidades;
        }

        public function get_habilidades_id($id_bruto) {
            $sql = "SELECT * FROM habilidad where id_habilidad in (select id_habilidad from bruto_habilidad where id_bruto = ?);";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $habilidades = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $habilidades;
        }

        function get_habilidades_bruto($id_bruto) {
            $sql = "SELECT id_habilidad FROM habilidad where id_habilidad in (select id_habilidad from bruto_habilidad where id_bruto = ?);";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $habilidades = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $habilidades;
        }

        function get_id_habilidades(){
            $sql = "SELECT id_habilidad FROM habilidad";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $habilidades = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $habilidades;
        }


        public function get_habilidades_efecto_id($id) {
            $sql = "select habilidad.id_habilidad, habilidad.nombre, habilidad.imagen from bruto_habilidad join habilidad on habilidad.id_habilidad = bruto_habilidad.id_habilidad where bruto_habilidad.id_bruto = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $habilidades = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $habilidades;
        }
        
        public function habilidad_random($id_bruto){
            $sql = "select id_habilidad from habilidad where id_habilidad not in (select id_habilidad from bruto_habilidad where id_bruto = ?) order by rand() limit 1;";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $habilidad = $resultado->fetch_all(MYSQLI_ASSOC);
            $sentencia->close();

            $sql = "insert into bruto_habilidad (id_bruto, id_habilidad) values (?, ?);";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("ii", $id_bruto, $habilidad[0]["id_habilidad"]);
            $sentencia->execute();

            return ["success" => true, "habilidad" => $habilidad[0]["id_habilidad"]];
        }
    }
?>