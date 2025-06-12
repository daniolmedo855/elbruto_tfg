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

        public function get_efectos_herramienta_id($id_herramienta) {
            $sql = "select efecto.id_efecto, efecto.nombre, multiplicador from efecto_herramienta join efecto on efecto.id_efecto = efecto_herramienta.id_efecto where efecto_herramienta.id_herramienta = ?;";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_herramienta);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $efectos = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $efectos;
        }

        public function get_efectos_habilidad_id($id_habilidad) {
            $sql = "select efecto.id_efecto, efecto.nombre, multiplicador from efecto_habilidad join efecto on efecto.id_efecto = efecto_habilidad.id_efecto where efecto_habilidad.id_habilidad = ?;";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_habilidad);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $efectos = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $efectos;
        }
    }
?>