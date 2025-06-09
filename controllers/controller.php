<?php
    header("Content-Type: application/json");
    if (isset($_REQUEST["action"])) {
        $accion = strtolower(trim($_REQUEST["action"]));
        $acciones_permitidas = ["get_brutos","get_habilidades", "get_herramientas","get_habilidades_bruto","get_herramientas_bruto", "get_brutos_nombre", "get_bruto_id", "get_animales_bruto", "get_combates_bruto", "get_id_bruto", "get_retado_bruto", "get_retador_bruto", "crear_bruto"];
        if (in_array($accion, $acciones_permitidas)) {
            $accion();
        }
    } else {
        header("Location: ../index.php");
        exit;
    }

    function get_brutos(){
        require_once "../models/bruto.php";
        sesion();
        $bd = new Bruto();
        $nombre = $_SESSION["usuario"];
        $brutos = $bd->get_brutos($nombre);
        echo json_encode($brutos);
    }

    function get_habilidades() {
        require_once "../models/habilidad.php";
        $habilidades = new Habilidad();
        $habilidades = $habilidades->get_habilidades();
        echo json_encode($habilidades);
    }

    function get_herramientas() {
        require_once "../models/herramienta.php";
        $bd = new Herramienta();
        $herramientas = $bd->get_herramientas();
        echo json_encode($herramientas);
    }

    function get_brutos_nombre() {
        require_once "../models/bruto.php";
        sesion();
        $bd = new Bruto();
        $nombre = $_SESSION["usuario"];
        $brutos = $bd->get_brutos_nombre($nombre);
        echo json_encode($brutos);
    }

    function get_bruto_id() {
        require_once "../models/bruto.php";
        sesion();
        $bd = new Bruto();
        $id_bruto = $_SESSION["bruto"];
        $brutos = $bd->get_bruto_id($id_bruto);
        echo json_encode($brutos);
    }

      function get_habilidades_bruto() {
        require_once "../models/habilidad.php";
        sesion();
        $habilidades = new Habilidad();
        $id_bruto = $_SESSION["bruto"];
        $habilidades = $habilidades->get_habilidades_bruto($id_bruto);
        echo json_encode($habilidades);
    }

    function get_herramientas_bruto() {
        require_once "../models/herramienta.php";
        sesion();
        $bd = new Herramienta();
        $id_bruto = $_SESSION["bruto"];
        $herramientas = $bd->get_herramientas_bruto($id_bruto);
        echo json_encode($herramientas);
    }

    function get_animales_bruto() {
        require_once "../models/animal.php";
        sesion();
        $bd = new Animal();
        $id_bruto = $_SESSION["bruto"];
        $animales = $bd->get_animales_bruto($id_bruto);
        echo json_encode($animales);
    }

    function get_combates_bruto() {
        require_once "../models/bruto.php";
        sesion();
        $bd = new Bruto();
        $id_bruto = $_SESSION["bruto"];
        $combates = $bd->get_combates_bruto($id_bruto);
        echo json_encode($combates);
    }

    function get_id_bruto(){
        require_once "../models/bruto.php";
        sesion();
        $bd = new Bruto();
        $nombre = $_SESSION["usuario"];
        $id_bruto = $bd->get_id_bruto_nombre($nombre);
        echo json_encode($id_bruto);
    }

    function get_retado_bruto(){
        require_once "../models/bruto.php";
        sesion();
        $bd = new Bruto();
        $id_bruto = $_GET["id_bruto"];
        $retado = $bd->get_bruto_id($id_bruto);
        echo json_encode($retado);
    }

    function get_retador_bruto(){
        require_once "../models/bruto.php";
        sesion();
        $bd = new Bruto();
        $id_bruto = $_SESSION["bruto"];
        $retador = $bd->get_bruto_id($id_bruto);
        echo json_encode($retador);
    }

    function get_retador_habilidades(){
        require_once "../models/habilidades.php";
        sesion();
        $bd = new Habilidad();
        $id_bruto = $_SESSION["bruto"];
        $retador = $bd->get_habilidades_efecto_id($id_bruto);
        echo json_encode($retador);
    }

    function get_retado_habilidades(){
        require_once "../models/habilidades.php";
        sesion();
        $bd = new Habilidad();
        $id_bruto = $_GET["id_bruto"];
        $resultado = $retado = $bd->get_habilidades_efecto_id($id_bruto);

        if(!$resultado["success"]){
            echo json_encode($resultado);
            return;
        }
        
        echo json_encode($retado);
    }

    function crear_bruto() {
        require_once "../models/bruto.php";
        sesion();
        $id_usuario = $_SESSION["usuario"];
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

    function sesion(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    function random_booleano($probabilidad){
        return mt_rand() / mt_getrandmax() < $probabilidad;
    }
?>