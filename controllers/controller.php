<?php
    header("Content-Type: application/json");
    if (isset($_REQUEST["action"])) {
        $accion = strtolower(trim($_REQUEST["action"]));
        $acciones_permitidas = ["get_usuarios", "get_brutos", "get_aspectos", "get_brutos_admin","get_habilidades", "get_herramientas","get_habilidades_bruto","get_herramientas_bruto", "get_brutos_nombre", "get_bruto_id", "get_animales_bruto", "get_combates_bruto", "get_id_bruto", "get_retado_bruto", "get_retador_bruto",  "get_retado_habilidades", "get_retador_habilidades","get_retado_herramientas", "get_retador_herramientas","get_retador_animales", "actualizar_resultado", "get_retado_animales", "get_brutos_ranking","crear_bruto" ,"borrar_usuario", "borrar_bruto"];
        if (in_array($accion, $acciones_permitidas)) {
            $accion();
        }
    } else {
        header("Location: ../index.php");
        exit;
    }

    function get_usuarios() {
        require_once "../models/usuario.php";
        $bd = new Usuario();
        $usuarios = $bd->get_usuarios();
        echo json_encode($usuarios);
    }

    function get_brutos(){
        require_once "../models/bruto.php";
        sesion();
        $bd = new Bruto();
        $nombre = $_SESSION["usuario"];
        $brutos = $bd->get_brutos($nombre);
        echo json_encode($brutos);
    }

    function get_brutos_admin(){
        require_once "../models/bruto.php";
        $bd = new Bruto();
        $brutos = $bd->get_brutos_admin();
        echo json_encode($brutos);
    }

    function get_aspectos() {
        require_once "../models/aspecto.php";
        $bd = new Aspecto();
        $aspectos = $bd->get_aspectos();
        echo json_encode($aspectos);
    }

    function get_habilidades() {
        require_once "../models/habilidad.php";
        require_once "../models/efecto.php";
        $habilidades = new Habilidad();
        $efecto = new Efecto();
        $habilidades = $habilidades->get_habilidades();
        foreach ($habilidades as &$habilidad) {
            $habilidad["efectos"] = $efecto->get_efectos_habilidad_id($habilidad["id_habilidad"]);
        }
        echo json_encode($habilidades);
    }

    function get_herramientas() {
        require_once "../models/herramienta.php";
        require_once "../models/efecto.php";
        $bd = new Herramienta();
        $efecto = new Efecto();
        $herramientas = $bd->get_herramientas();
        foreach ($herramientas as &$herramienta) {
            $herramienta["efectos"] = $efecto->get_efectos_herramienta_id($herramienta["id_herramienta"]);
        }
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

    function get_retado_habilidades(){
        require_once "../models/habilidad.php";
        require_once "../models/efecto.php";
        $efecto = new Efecto();
        $bd = new Habilidad();
        $id_bruto = $_GET["id_bruto"];
        $retado = $bd->get_habilidades_efecto_id($id_bruto);
        foreach ($retado as &$habilidad) {
            $habilidad["efectos"] = $efecto->get_efectos_habilidad_id($habilidad["id_habilidad"]);
        }
        echo json_encode($retado);
    }

    function get_retador_habilidades(){
        require_once "../models/habilidad.php";
        require_once "../models/efecto.php";
        sesion();
        $efecto = new Efecto();
        $bd = new Habilidad();
        $id_bruto = $_SESSION["bruto"];
        $retador = $bd->get_habilidades_efecto_id($id_bruto);
        foreach ($retador as &$habilidad) {
            $habilidad["efectos"] = $efecto->get_efectos_habilidad_id($habilidad["id_habilidad"]);
        }
        echo json_encode($retador);
    } 
    
    function get_retado_herramientas(){
        require_once "../models/herramienta.php";
        require_once "../models/efecto.php";
        $efecto = new Efecto();
        $bd = new Herramienta();
        $id_bruto = $_GET["id_bruto"];
        $retado = $bd->get_herramientas_efecto_id($id_bruto);
        foreach ($retado as &$herramienta) {
            $herramienta["efectos"] = $efecto->get_efectos_herramienta_id($herramienta["id_herramienta"]);
        }
        echo json_encode($retado);
    }

    function get_retador_herramientas(){
        require_once "../models/herramienta.php";
        require_once "../models/efecto.php";
        $efecto = new Efecto();
        sesion();
        $bd = new Herramienta();
        $id_bruto = $_SESSION["bruto"];
        $retador = $bd->get_herramientas_efecto_id($id_bruto);
        foreach ($retador as &$herramienta) {
            $herramienta["efectos"] = $efecto->get_efectos_herramienta_id($herramienta["id_herramienta"]);
        }
        echo json_encode($retador);
    } 

    function get_retado_animales(){
        require_once "../models/animal.php";
        $bd = new Animal();
        $id_bruto = $_GET["id_bruto"];
        $retado = $bd->get_animales_id($id_bruto);
        echo json_encode($retado);
    }

    function get_retador_animales(){
        require_once "../models/animal.php";
        sesion();
        $bd = new Animal();
        $id_bruto = $_SESSION["bruto"];
        $retador = $bd->get_animales_id($id_bruto);
        echo json_encode($retador);
    } 

    function get_brutos_ranking() {
        require_once "../models/bruto.php";
        $bd = new Bruto();
        $brutos = $bd->get_brutos_ranking();
        echo json_encode($brutos);
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

    function actualizar_resultado() {
        require_once "../models/bruto.php";
        require_once "../models/combate.php";
        $combate = new Combate();
        $bruto = new Bruto();
        $id_ganador = $_GET["id_ganador"];
        $id_perdedor = $_GET["id_perdedor"];

        $combate->insertar_combate($id_ganador, $id_perdedor);
        $brutos = $bruto->actualizar_resultado($id_ganador, $id_perdedor);

        if($brutos["ganador"]["experiencia"]>=10){
            $bruto->subir_nivel($brutos["ganador"]["id_bruto"]);

            $recompensas = ["estadisticas", "habilidad", "herramienta", "animal"];
            $aleatoria = $recompensas[mt_rand(0, count($recompensas) - 1)];
            
            switch($aleatoria){
                case "estadisticas":
                    $aleatoria = ["vida", "fuerza", "velocidad"];
                    $aleatoria = $aleatoria[mt_rand(0, count($aleatoria) - 1)];
                    $cantidad = mt_rand(1, 2);
                    $brutos["recompensa"] = $bruto->asignar_recompensa($brutos["ganador"]["id_bruto"], $aleatoria, $cantidad);
                    $brutos["sube"] =  ["ganador", "estadisticas"];
                    break;
                case "habilidad":
                    require_once "../models/habilidad.php";
                    $habilidad = new Habilidad();
                    $brutos["recompensa"] = $habilidad->habilidad_random($brutos["ganador"]["id_bruto"]);
                    $brutos["sube"] =  ["ganador", "habilidad"];
                    break;
                case "herramienta":
                    require_once "../models/herramienta.php";
                    $herramienta = new Herramienta();
                    $brutos["recompensa"] = $herramienta->herramienta_random($brutos["ganador"]["id_bruto"]);
                    $brutos["sube"] =  ["ganador", "herramienta"];
                    break;
                case "animal":
                    require_once "../models/animal.php";
                    $animal = new Animal();
                    if($animal->get_animales_id($brutos["ganador"]["id_bruto"])>0){
                        $aleatoria = ["vida", "fuerza", "velocidad"];
                        $aleatoria = $aleatoria[mt_rand(0, count($aleatoria) - 1)];
                        $cantidad = mt_rand(1, 2);
                        $brutos["recompensa"] = $bruto->asignar_recompensa($brutos["ganador"]["id_bruto"], $aleatoria, $cantidad);
                        $brutos["sube"] =  ["ganador", "estadisticas"];
                    } else {
                        $brutos["recompensa"] = $animal->animal_random($brutos["ganador"]["id_bruto"]);
                        $brutos["sube"] =  ["ganador", "animal"];
                    }
                    break;
            }

            
        }

        if($brutos["perdedor"]["experiencia"]>=10){
            $bruto->subir_nivel($brutos["perdedor"]["id_bruto"]);

            $recompensas = ["estadisticas", "habilidad", "herramienta", "animal"];
            $aleatoria = $recompensas[mt_rand(0, count($recompensas) - 1)];
            
            switch($aleatoria){
                case "estadisticas":
                    $aleatoria = ["vida", "fuerza", "velocidad"];
                    $aleatoria = $aleatoria[mt_rand(0, count($aleatoria) - 1)];
                    $cantidad = mt_rand(1, 2);
                    $brutos["recompensa"] = $bruto->asignar_recompensa($brutos["perdedor"]["id_bruto"], $aleatoria, $cantidad);
                    $brutos["sube"] =  ["perdedor", "estadisticas"];
                    break;
                case "habilidad":
                    require_once "../models/habilidad.php";
                    $habilidad = new Habilidad();
                    $brutos["recompensa"] = $habilidad->habilidad_random($brutos["perdedor"]["id_bruto"]);
                    $brutos["recompensa"] =  ["perdedor", "habilidad"];
                    break;
                case "herramienta":
                    require_once "../models/herramienta.php";
                    $herramienta = new Herramienta();
                    $brutos["recompensa"] = $herramienta->herramienta_random($brutos["perdedor"]["id_bruto"]);
                    $brutos["sube"] = ["perdedor", "herramienta"];
                    break;
                case "animal":
                    require_once "../models/animal.php";
                    $animal = new Animal();
                    if($animal->get_animales_id($brutos["perdedor"]["id_bruto"])>0){
                        $aleatoria = ["vida", "fuerza", "velocidad"];
                        $aleatoria = $aleatoria[mt_rand(0, count($aleatoria) - 1)];
                        $cantidad = mt_rand(1, 2);
                        $brutos["recompensa"] = $bruto->asignar_recompensa($brutos["perdedor"]["id_bruto"], $aleatoria, $cantidad);
                        $brutos["sube"] =  ["perdedor", "estadisticas"];
                    } else {
                         $brutos["recompensa"] = $animal->animal_random($brutos["perdedor"]["id_bruto"]);
                         $brutos["sube"] =  ["perdedor", "animal"];
                    }
                    break;
            }
            
        }

        echo json_encode($brutos);
    }

    function borrar_usuario() {
        require_once "../models/usuario.php";
        $bd = new Usuario();
        $id = $_GET["id_usuario"];

        $resultado = $bd->borrar_usuario($id);

        if ($resultado) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "No se pudo borrar el usuario."]);
        }
    }

    function borrar_bruto() {
        require_once "../models/bruto.php";
        $bd = new Bruto();
        $id = $_GET["id_bruto"];

        $resultado = $bd->borrar_bruto($id);

        if ($resultado) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "No se pudo borrar el bruto."]);
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