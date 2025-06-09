<?php require_once "header_home.php"; ?>
<main>
    <section class="crear_bruto">
        <form class="form">
            <input type="hidden" name="action" value="crear_bruto">
            <input type="hidden" value="" name="apariencia">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <div class="apariencia">
                <div class="carrusel">
                    <button class="anterior" type="button">←</button>
                    <div class="imagenes">
                        <img src="img/aspectos/aspecto_1.png" alt="">
                        <img src="img/aspectos/aspecto_2.png" alt="">
                        <img src="img/aspectos/aspecto_3.png" alt="">
                        <img src="img/aspectos/aspecto_4.png" alt="">
                        <img src="img/aspectos/aspecto_5.png" alt="">
                        <img src="img/aspectos/aspecto_6.png" alt="">
                    </div>
                    <button class="siguiente" type="button">→</button>
                </div>
            </div>
            
            <input type="submit" value="Crear" class="btn"> 
        </form>
    </section>
</main>

<script src="scripts/crear_bruto.js"></script>