<header>
    <nav class="navbar_home">
        <div class="menu">
            <a href="index.php?action=home" class="btn">HOME</a>
            <a href="index.php?action=ranking" class="btn">RANKING</a>
            <?php if(isset($_SESSION["admin"])){ echo '<a href="index.php?action=home" class="btn">Admin</a>'; } ?>
            <a href="index.php?action=logout" class="btn">Logout</a>
        </div>
    </nav>
</header>