<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <span class="navbar-text">
        <a href="<?php echo FRONT_ROOT ?>Home/Index">
            <strong>
            <?php
                echo Utils\Utils::getLoggedUserFullName();
            ?>
            </strong>
        </a>
    </span>
    <ul class="navbar-nav ml-auto">
        <?php
        if (Utils\Utils::isAdmin())
            include_once('nav-admin.php');
        ?>
        <li class="nav-item"><a class="nav-link" href="<?php echo FRONT_ROOT ?>Student/ShowListView">Listar Alumnos</a></li>;
        <li class="nav-item"><a class="nav-link" href="<?php echo FRONT_ROOT ?>Login/Logout">Cerrar Sesión</a></li>;
    </ul>
</nav>