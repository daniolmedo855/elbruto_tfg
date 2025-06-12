<?php
    if(!isset($_SESSION["admin"])){
        header("Location: index.php");
        exit;
    }

    require_once "header_home.php";
?>

<main>
    <section class="admin">
        <div class="buscador">  
            <form class="form_admin">
                <select>
                    <option value="usuarios">Usuarios</option>
                    <option value="brutos">Brutos</option>
                </select>
            </form>
            <button class="btn" type="button">AÑADIR</button>
        </div>
            
        <div class="tabla"></div>
    </section>
</main> 

<script src="scripts/admin.js"></script>