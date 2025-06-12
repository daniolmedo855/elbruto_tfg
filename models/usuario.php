<?php
    require_once "bd.php";

    class Usuario extends BD{
        protected $id_usuario;
        protected $nombre;
        protected $contrasenia;
        protected $tipo;

        public function __construct($id_usuario=null, $nombre=null, $contrasenia=null, $tipo=null){
            parent::__construct();
            $this->id_usuario = $id_usuario;
            $this->nombre = $nombre;
            $this->contrasenia = $contrasenia;
            $this->tipo = $tipo;
        }

        function get_usuarios() {
            $sql = "SELECT id_usuario, nombre FROM usuario";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->execute();
            $sentencia->bind_result($id_usuario, $nombre);
            $resultado = $sentencia->get_result();
            $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
            $sentencia->close();
            return $usuarios;
        }

        public function register($nombre, $password) {
            $count = 0;
            $sql = "SELECT count(*) FROM usuario WHERE nombre = ?";
            $sentencia = $this->bd->prepare($sql);
            if (!$sentencia) {
                return ["success" => false, "error" => "Error de base de datos al preparar verificación."];
            }

            $sentencia->bind_param("s", $nombre);
            $sentencia->execute();
            $sentencia->bind_result($count);
            $sentencia->fetch();
            $sentencia->close();

            if ($count > 0) {
                return [
                    "success" => false,
                    "error" => "El nombre de usuario ya está en uso."
                ];
            }

            if (!preg_match("'^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$'", $password)) {
                return [
                    "success" => false,
                    "error" => "La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un símbolo."
                ];
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuario (nombre, contrasenia) VALUES (?, ?)";
            $sentencia = $this->bd->prepare($sql);
            if (!$sentencia) {
                return ["success" => false, "error" => "Error al preparar inserción."];
            }

            $sentencia->bind_param("ss", $nombre, $passwordHash);
            $sentencia->execute();
            $sentencia->close();

            $sql = "SELECT tipo FROM usuario WHERE nombre = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("s", $nombre);
            $sentencia->execute();
            $sentencia->bind_result($tipo);
            $sentencia->fetch();
            $sentencia->close();

            if($tipo == 1) {
                return ["success" => true, "admin" => true];
            }

            return ["success" => true];
        }

        public function login($nombre, $password) {
            $sql = "SELECT contrasenia FROM usuario WHERE nombre = ?";
            $sentencia = $this->bd->prepare($sql);

            if (!$sentencia) {
                return ["success" => false, "error" => "Error de base de datos al preparar verificación."];
            }

            $sentencia->bind_param("s", $nombre);
            $sentencia->execute();
            $sentencia->bind_result($hashAlmacenado);

            if ($sentencia->fetch()) {
                $sentencia->close();

                if (password_verify($password, $hashAlmacenado)) {
                    $sql = "SELECT tipo FROM usuario WHERE nombre = ?";
                    $sentencia = $this->bd->prepare($sql);
                    $sentencia->bind_param("s", $nombre);
                    $sentencia->execute();
                    $sentencia->bind_result($tipo);
                    $sentencia->fetch();
                    $sentencia->close();

                    if($tipo == 1) {
                        return ["success" => true, "admin" => true];
                    }
                    return ["success" => true];
                } else {
                    return ["success" => false, "error" => "La contraseña es incorrecta."];
                }
            } else {
                $sentencia->close();
                return ["success" => false, "error" => "El usuario no existe."];
            }
        }

        public function borrar_usuario($id_usuario) {
            $sql = "DELETE FROM usuario WHERE id_usuario = ?";
            $sentencia = $this->bd->prepare($sql);
            $sentencia->bind_param("i", $id_usuario);
            $sentencia->execute();
            
            $filas_afectadas = $sentencia->affected_rows;
            $sentencia->close();

            return $filas_afectadas > 0;
        }

        public function modificar_usuario($id_usuario, $nombre, $password) {
            $count = 0;
            $sql = "SELECT count(*) FROM usuario WHERE nombre = ?";
            $sentencia = $this->bd->prepare($sql);
            if (!$sentencia) {
                return ["success" => false, "error" => "Error de base de datos al preparar verificación."];
            }

            $sentencia->bind_param("s", $nombre);
            $sentencia->execute();
            $sentencia->bind_result($count);
            $sentencia->fetch();
            $sentencia->close();

            if ($count > 0) {
                return [
                    "success" => false,
                    "error" => "El nombre de usuario ya está en uso."
                ];
            }

            if (!preg_match("'^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$'", $password)) {
                return [
                    "success" => false,
                    "error" => "La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un símbolo."
                ];
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE usuario SET nombre = ?, contrasenia = ? WHERE id_usuario = ?";
            $sentencia = $this->bd->prepare($sql);
            if (!$sentencia) {
                return ["success" => false, "error" => "Error al preparar inserción."];
            }

            $sentencia->bind_param("ssi", $nombre, $passwordHash, $id_usuario);
            $sentencia->execute();
            $sentencia->close();

            return ["success" => true];
        }

    }

    
?>