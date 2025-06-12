<?php
    require_once "../models/usuario.php";
    header("Content-Type: application/json");
    if (isset($_REQUEST["action"])) {
        $accion = strtolower(trim($_REQUEST["action"]));
        $acciones_permitidas = ["login", "register", "crear_usuario", "modificar_usuario", "crear_bruto"];
        if (in_array($accion, $acciones_permitidas)) {
            $accion();
        }
    } else {
        header("Location: ../index.php");
        exit;
    }


    function register(){
        $nombre = $_POST["username"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        if($password == $password2){
            $bd = new Usuario();
            $resultado = $bd->register($nombre, $password);
            if ($resultado["success"]) {
                sesion();
                $_SESSION["usuario"] = $nombre;

                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => $resultado["error"] ?? "No se pudo registrar"
                ]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Las contraseñas no coinciden"]);
        }
    }

    function login(){
        $nombre = $_POST["username"];
        $password = $_POST["password"];
        $bd = new Usuario();
        $resultado = $bd->login($nombre, $password);

        if ($resultado["success"]) {
            sesion();
            $_SESSION["usuario"] = $nombre;

            if ($resultado["admin"]) {
                $_SESSION["admin"] = true;
            }

            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => $resultado["error"] ?? "No se pudo iniciar sesion"
            ]);
        }
    }

    function crear_usuario() {
        $nombre = $_POST["username"];
        $password = $_POST["password"];
        $bd = new Usuario();
        $resultado = $bd->register($nombre, $password);
        if ($resultado["success"]) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => $resultado["error"] ?? "No se pudo registrar"
            ]);
        }
    }

    function modificar_usuario(){
        $id = $_POST["id_usuario"];
        $nombre = $_POST["username"];
        $password = $_POST["password"];
        $bd = new Usuario();
        $resultado = $bd->modificar_usuario($id, $nombre, $password);
        if ($resultado["success"]) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => $resultado["error"] ?? "No se pudo modificar"
            ]);
        }
    }

    function crear_bruto() {
        require_once "../models/bruto.php";
        $id_usuario = $_POST["usuario"];
        $nombre = $_POST["nombre"];
        $id_aspecto = $_POST["apariencia"];

        //ATRIBUTOS
        //50% de obtener mejores atributos que los base
        $vida = 50;
        if (random_booleano(0.5)) {
            $vida += 10;
        }
        $fuerza = 5;
        if (random_booleano(0.5)) {
            $fuerza += 3;
        }
        $velocidad = 5;
        if (random_booleano(0.5)) {
            $velocidad += 2;
        }

        $bruto = new Bruto();
        $resultado = $bruto->crear_bruto($nombre, $vida, $fuerza, $velocidad, $id_usuario, $id_aspecto);
        
        if (!$resultado["success"]) {
            echo json_encode($resultado);
            return;
        }
    
        $id_bruto = $resultado["id_bruto"];

        //HERRAMIENTAS
        //20% de obtener una herramienta aleatoria
        if (random_booleano(0.2)) {
            require_once "../models/herramienta.php";
            $herramienta = new Herramienta();
            $herramientas = $herramienta->get_id_herramientas();
            $aleatoria = $herramientas[mt_rand(0, count($herramientas) - 1)];
            $id_herramienta = $aleatoria["id_herramienta"];
            $resultado = $bruto->asignar_herramienta($id_bruto, $id_herramienta);

            if (!$resultado["success"]) {
                echo json_encode($resultado);
                return;
            }
        }

        //HABILIDADES
        //20% de obtener una habilidad aleatoria
        if (random_booleano(0.2)) {
            require_once "../models/habilidad.php";
            $habilidad = new Habilidad();
            $habilidades = $habilidad->get_id_habilidades();
            $aleatoria = $habilidades[mt_rand(0, count($habilidades) - 1)];
            $id_habilidad = $aleatoria["id_habilidad"];
            $resultado = $bruto->asignar_habilidad($id_bruto, $id_habilidad);

            if (!$resultado["success"]) {
                echo json_encode($resultado);
                return;
            }
        }

        //ANIMALES
        //10% de obtener un animal aleatorio
        if (random_booleano(0.1)) {
            require_once "../models/animal.php";
            $animal = new Animal();
            $animales = $animal->get_id_animales();
            $aleatorio = $animales[mt_rand(0, count($animales) - 1)];
            $id_animal = $aleatorio["id_animal"];
            $resultado = $bruto->asignar_animal($id_bruto, $id_animal);

            if (!$resultado["success"]) {
                echo json_encode($resultado);
                return;
            }
        }

        echo json_encode(["success" => true, "id_bruto" => $id_bruto]);
    }

    function modificar_bruto(){
        $id = $_POST["id_bruto"];
        $nombre = $_POST["username"];
        $vida = $_POST["vida"];
        $fuerza = $_POST["fuerza"];
        $velocidad = $_POST["velocidad"];
        $nivel = $_POST["nivel"];
        $experiencia = $_POST["experiencia"];
        $puntos_arena = $_POST["puntos_arena"];     
        $bd = new Bruto();
        $resultado = $bd->modificar_bruto($id, $nombre, $password);
        if ($resultado["success"]) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => $resultado["error"] ?? "No se pudo modificar"
            ]);
        }
    }

    function sesion(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    function random_booleano($probabilidad){
        return mt_rand() / mt_getrandmax() < $probabilidad;
    }
?>