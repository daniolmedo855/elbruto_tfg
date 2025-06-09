<form class="form">
    <input type="hidden" name="action" value="<?php echo $_REQUEST['action'] == 'login' ? 'login' : 'register'; ?>">
    <input type="text" name="username" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <?php 
        if($_REQUEST['action'] == 'register'){
            echo '<input type="password" name="password2" placeholder="Repetir Contraseña" required>';
        }

    ?>
    <input type="submit" value="<?php echo $_REQUEST['action'] == 'login' ? 'Iniciar Sesion' : 'Registrarse'; ?>" class="btn">

    <div>
        <a href="index.php" class="btn">Volver</a> 
        <a href="<?php echo $_REQUEST['action'] == 'login' ? 'index.php?action=register' : 'index.php?action=login'; ?>" class="btn"><?php echo $_REQUEST['action'] == 'login' ? 'Registrarse' : 'Iniciar Sesion'; ?></a>
    </div>
</form>

<script src="scripts/form.js"></script>