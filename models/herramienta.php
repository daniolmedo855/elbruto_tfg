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

        public function get_efectos_herramientas_id($id) {
            $sql = "SELECT herramienta.id_herramienta, efecto.nombre, multiplicador 
            FROM efecto 
            JOIN efecto_herramienta ON efecto.id_efecto = efecto_herramienta.id_efecto 
            JOIN herramienta ON herramienta.id_herramienta = efecto_herramienta.id_herramienta 
            WHERE herramienta.id_herramienta = ?;";
    
            $sentencia = $this->bd->prepare($sql);
            if (!$sentencia) {
                return [];
            }

            if (!$sentencia->bind_param("i", $id)) {
                $sentencia->close();
                return [];
            }

            if (!$sentencia->execute()) {
                $sentencia->close();
                return [];
            }

            $resultado = $sentencia->get_result();
            if (!$resultado) {
                $sentencia->close();
                return []; 
            }

            $herramientas = $resultado->fetch_all(MYSQLI_ASSOC);
            $sentencia->close();

            return $herramientas ?: [];
        }
    }
?>