<?php
    require_once "bd.php";

    class Bruto extends BD{
        protected $id_bruto;
        protected $nombre;
        protected $nivel;
        protected $vida;
        protected $fuerza;
        protected $velocidad;
        protected $puntos_arena;
        protected $experiencia;
        protected $id_usuario;
        protected $id_aspecto;

        public function __construct($id_bruto=null, $nombre=null, $nivel=null, $vida=null, $fuerza=null, $velocidad=null, $puntos_arena=null, $experiencia=null, $id_usuario=null, $id_aspecto=null){
            parent::__construct();
            $this->id_bruto = $id_bruto;
            $this->nombre = $nombre;
            $this->nivel = $nivel;
            $this->vida = $vida;
            $this->fuerza = $fuerza;
            $this->velocidad = $velocidad;
            $this->puntos_arena = $puntos_arena;
            $this->experiencia = $experiencia;
            $this->id_usuario = $id_usuario;
            $this->id_aspecto = $id_aspecto;
        }

        function get_brutos($nombre) {
            $sql = "SELECT * FROM bruto where id_usuario != (select id_usuario from usuario where nombre = ?) order by nivel desc";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->bind_param("s", $nombre);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $brutos = $resultado->fetch_all(MYSQLI_ASSOC);
            $sentencia->close();
            return $brutos;
        }

        public function get_brutos_nombre($nombre) {
            $sql = "SELECT * FROM bruto where id_usuario = (select id_usuario from usuario where nombre = ?)";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->bind_param("s", $nombre);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $brutos = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $brutos;
        }

        public function get_bruto_id($id_bruto) {
            $sql = "SELECT * FROM bruto where id_bruto = ?";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $bruto = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $bruto;
        }
        
        function get_combates_bruto($id_bruto) {
            $sql = "SELECT COUNT(*) combates FROM combate WHERE (id_ganador = ? OR id_perdedor = ?) AND DATE(fecha) = CURDATE();";
            $sentencia = $this->bd->prepare($sql);

            $sentencia->bind_param("ii", $id_bruto, $id_bruto);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $combates = $resultado->fetch_all(MYSQLI_ASSOC);

            $sentencia->close();

            return $combates;
        }

        function get_id_bruto_nombre($nombre){
            $sql = "SELECT id_bruto FROM bruto WHERE id_usuario = (SELECT id_usuario FROM usuario WHERE nombre = ?)";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("s", $nombre);
            $sentencia->execute();
            $sentencia->bind_result($id_bruto);
            $sentencia->fetch();
            $sentencia->close();
            return $id_bruto;
        }

        public function crear_bruto($nombre, $vida, $fuerza, $velocidad, $nombre_usuario, $id_aspecto){
            $id_usuario=0;
            $sql = "select id_usuario from usuario where nombre = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("s", $nombre_usuario);
            $sentencia->execute();
            $sentencia->bind_result($id_usuario);
            $sentencia->fetch();
            $sentencia->close();

            $sql = "select count(*) from bruto where id_usuario = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_usuario);
            $sentencia->execute();
            $sentencia->bind_result($count);
            $sentencia->fetch();
            $sentencia->close();

            if ($count > 2) {
                return ["success" => false, "error" => "El usuario ya tiene 3 brutos."];
            }

            $sql = "select count(*) from bruto where nombre = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("s", $nombre);
            $sentencia->execute();
            $sentencia->bind_result($count);
            $sentencia->fetch();
            $sentencia->close();

            if ($count > 0) {
                return ["success" => false, "error" => "Ya existe un bruto con ese nombre."];
            }

            $sql = "INSERT INTO bruto (nombre, vida, fuerza, velocidad, id_usuario, id_aspecto) VALUES (?, ?, ?, ?, ?, ?)";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("siiiii", $nombre, $vida, $fuerza, $velocidad, $id_usuario, $id_aspecto);
            $sentencia->execute();

            if ($sentencia->error) {
                return ["success" => false, "error" => "Error de base de datos al crear el bruto."];
            } else {
                $sql = "select id_bruto from bruto where nombre = ?";
                $sentencia = $this->bd->prepare($sql);
                $sentencia->bind_param("s", $nombre);
                $sentencia->execute();
                $sentencia->bind_result($id_bruto);
                $sentencia->fetch();
                $sentencia->close();
                return ["success" => true, "id_bruto" => $id_bruto];
            }

            $sentencia->close();
        }

        public function asignar_habilidad($id_bruto, $id_habilidad){
            $sql = "select count(*) from bruto_habilidad where id_bruto = ? and id_habilidad = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("ii", $id_bruto, $id_habilidad);
            $sentencia->execute();
            $sentencia->bind_result($count);
            $sentencia->fetch();
            $sentencia->close();

            if ($count > 0) {
                return ["success" => false, "error" => "El bruto ya tiene esa habilidad."];
            }

            $sql = "INSERT INTO bruto_habilidad (id_bruto, id_habilidad) VALUES (?, ?)";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("ii", $id_bruto, $id_habilidad);
            $sentencia->execute();

            if ($sentencia->error) {
                return ["success" => false, "error" => "Error al asignar la habilidad"];
            } else {
                return ["success" => true];
            }
        }

        public function asignar_herramienta($id_bruto, $id_herramienta){
            $sql = "select count(*) from bruto_herramienta where id_bruto = ? and id_herramienta = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("ii", $id_bruto, $id_herramienta);
            $sentencia->execute();
            $sentencia->bind_result($count);
            $sentencia->fetch();
            $sentencia->close();

            if ($count > 0) {
                return ["success" => false, "error" => "El bruto ya tiene esa herramienta."];
            }

            $sql = "INSERT INTO bruto_herramienta (id_bruto, id_herramienta) VALUES (?, ?)";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("ii", $id_bruto, $id_herramienta);
            $sentencia->execute();

            if ($sentencia->error) {
                return ["success" => false, "error" => "Error al asignar la herramienta"];
            } else {
                return ["success" => true];
            }
        }


        public function asignar_animal($id_bruto, $id_animal){
            $sql = "select count(*) from bruto_animal where id_bruto = ? and id_animal = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("ii", $id_bruto, $id_herramienta);
            $sentencia->execute();
            $sentencia->bind_result($count);
            $sentencia->fetch();
            $sentencia->close();

            if ($count > 0) {
                return ["success" => false, "error" => "El bruto ya tiene esa mascota."];
            }

            $sql = "INSERT INTO bruto_animal (id_bruto, id_animal) VALUES (?, ?)";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("ii", $id_bruto, $id_animal);
            $sentencia->execute();

            if ($sentencia->error) {
                return ["success" => false, "error" => "Error al asignar la mascota"];
            } else {
                return ["success" => true];
            }
        }

        public function actualizar_resultado($id_ganador, $id_perdedor) {
            $sql = "update bruto set puntos_arena = puntos_arena + 1, experiencia = experiencia + 2 where id_bruto = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_ganador);
            $sentencia->execute();

            $sql = "update bruto set experiencia = experiencia + 1 where id_bruto = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_perdedor);
            $sentencia->execute();

            $sentencia->close();

            $sql = "select id_bruto, experiencia from bruto where id_bruto = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_ganador);
            $sentencia->execute();
            $sentencia->bind_result($id_bruto_ganador, $experiencia_bruto_ganador);
            $sentencia->fetch();
            $sentencia->close();

            $sql = "select id_bruto, experiencia from bruto where id_bruto = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_perdedor);
            $sentencia->execute();
            $sentencia->bind_result($id_bruto_perdedor, $experiencia_bruto_perdedor);
            $sentencia->fetch();
            $sentencia->close();

            return ["ganador" => ["experiencia" => $experiencia_bruto_ganador, "id_bruto" => $id_bruto_ganador], "perdedor" => ["experiencia" => $experiencia_bruto_perdedor, "id_bruto" => $id_bruto_perdedor]];
        }

        public function subir_nivel($id_bruto){
            $sql = "update bruto set nivel = nivel + 1, experiencia = 0 where id_bruto = ?";

            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();

            $sentencia->close();

            return ["success" => true];
        }

        public function asignar_recompensa($id_bruto, $recompensa, $cantidad){
            $recompensa_permitida = ["fuerza", "vida", "velocidad"];
            if(!in_array($recompensa, $recompensa_permitida)){
                return false;
            }
            $sql = "update bruto set $recompensa = $recompensa + $cantidad where id_bruto = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();
            $sentencia->close();

            return ["success" => true];
        }
        public function get_brutos_ranking(){
            $sql = "select bruto.id_bruto, bruto.nombre, bruto.puntos_arena, bruto.id_aspecto from bruto order by puntos_arena desc";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $brutos = $resultado->fetch_all(MYSQLI_ASSOC);
            $sentencia->close();
            return $brutos;
        }

        public function get_brutos_admin(){
            $sql = "select bruto.id_bruto, bruto.nombre, bruto.experiencia, bruto.nivel, bruto.vida, bruto.fuerza, bruto.velocidad, bruto.puntos_arena, bruto.id_aspecto, usuario.nombre nombre_usuario from bruto inner join usuario on bruto.id_usuario = usuario.id_usuario";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $brutos = $resultado->fetch_all(MYSQLI_ASSOC);
            $sentencia->close();
            return $brutos;
        }

        public function borrar_bruto($id_bruto) {
            $sql = "DELETE FROM bruto WHERE id_bruto = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_bruto);
            $sentencia->execute();
            
            $filas_afectadas = $sentencia->affected_rows;
            $sentencia->close();

            return $filas_afectadas > 0;
        }
    }
?>