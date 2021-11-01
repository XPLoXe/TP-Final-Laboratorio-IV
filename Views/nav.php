<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <span class="navbar-text">
            <strong>
            <?php
                use Utils\Utils as Utils;

                echo Utils::getLoggedUserFullName();
            ?>
            </strong>
        </a>
    </span>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="<?php echo FRONT_ROOT ?>Home/Index">Inicio</a>
        <?php
        if (Utils::isAdmin())
            include_once('nav-admin.php');
        ?>
        <li class="nav-item"><a class="nav-link" href="<?php echo FRONT_ROOT ?>JobOffer/ShowListView">Ofertas Laborales</a></li>;
        <li class="nav-item"><a class="nav-link" href="<?php echo FRONT_ROOT ?>Student/ShowListView">Alumnos</a></li>;
        <li class="nav-item"><a class="nav-link" href="<?php echo FRONT_ROOT ?>Company/ShowListView">Compañías</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo FRONT_ROOT ?>Login/Logout">Cerrar Sesión</a></li>;
    </ul>
</nav>