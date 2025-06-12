<?php
    require_once "bd.php";

    class Herramienta extends BD{
        protected $id_herramienta;
        protected $nombre;
        protected $tipo;
        protected $danio;
        protected $imagen;

        public function __construct($id_herramienta=null, $nombre=null, $tipo=null, $danio=null, $imagen=null){
            parent::__construct();
            $this->id_herramienta = $id_herramienta;
            $this->nombre = $nombre;
            $this->tipo = $tipo;
            $this->danio = $danio;
            $this->imagen = $imagen;
        }

        public function get_herramientas() {
            $sql = "SELECT * FROM herramienta";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $habilidades = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $habilidades;
        }

        function get_herramientas_bruto($id_bruto){
            $sql = "SELECT id_herramienta FROM herramienta where id_herramienta in (select id_herramienta from bruto_herramienta where id_bruto = ?);";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $herramientas = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $herramientas;
        }

        function get_id_herramientas(){
            $sql = "SELECT id_herramienta FROM herramienta";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $herramientas = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $herramientas;
        }

        public function get_herramientas_efecto_id($id) {
            $sql = "select herramienta.id_herramienta, herramienta.nombre, herramienta.danio, herramienta.imagen from bruto_herramienta join herramienta on herramienta.id_herramienta = bruto_herramienta.id_herramienta where bruto_herramienta.id_bruto = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $herramientas = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $herramientas;
        }

        public function herramienta_random($id_bruto){
            $sql = "select id_herramienta from herramienta where id_herramienta not in (select id_herramienta from bruto_herramienta where id_bruto = ?) order by rand() limit 1;";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $herramienta = $resultado->fetch_all(MYSQLI_ASSOC);
            $sentencia->close();

            $sql = "insert into bruto_herramienta (id_bruto, id_herramienta) values (?, ?);";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("ii", $id_bruto, $herramienta[0]["id_herramienta"]);
            $sentencia->execute();

            return ["success" => true, "herramienta" => $herramienta[0]["id_herramienta"]];
        }
    }
?>