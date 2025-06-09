<?php
    require_once "../models/usuario.php";
    header("Content-Type: application/json");
    if (isset($_REQUEST["action"])) {
        $accion = strtolower(trim($_REQUEST["action"]));
        $acciones_permitidas = ["login", "register"];
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

    function sesion(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
?>