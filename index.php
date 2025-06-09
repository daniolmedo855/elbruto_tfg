<?php
    

    if (isset($_REQUEST["action"])) {
        $accion = strtolower(trim($_REQUEST["action"]));
        $acciones_permitidas = ["login", "register", "home" , "logout" , "crear_bruto", "inventario", "buscador", "arena"];
        if (in_array($accion, $acciones_permitidas)) {
            $accion();
        }
    } else {
        sesion();
        if(isset($_SESSION["usuario"])){
            if($_SESSION["usuario"] != null){
                home();
            } 
        } else {
            inicio();
        }
    }

    function inicio(){
        $contenido = "views/landing.php";
        require_once "views/plantilla.php";
    }

    function login(){
        $contenido = "views/form.php";
        require_once "views/plantilla.php";
    }

    function register(){
        $contenido = "views/form.php";
        require_once "views/plantilla.php";
    }

    function home(){
        sesion();
        $contenido = "views/home.php";
        require_once "views/plantilla.php";
    }

    function logout(){
        sesion();
        session_destroy();
        header("Location: index.php");
    }

    function crear_bruto(){
        sesion();
        $contenido = "views/crear_bruto.php";
        require_once "views/plantilla.php";
    }

    function inventario(){
        sesion();
        $_SESSION["bruto"] = $_GET["id_bruto"];
        $contenido = "views/inventario.php";
        require_once "views/plantilla.php";
    }

    function buscador(){
        sesion();
        $contenido = "views/buscador.php";
        require_once "views/plantilla.php";
    }

    function arena(){
        sesion();
        $contenido = "views/arena.php";
        require_once "views/plantilla.php";
    }

    function sesion(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

?>