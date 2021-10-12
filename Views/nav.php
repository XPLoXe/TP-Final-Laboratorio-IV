<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <span class="navbar-text">
        <strong>
            <?php 
            if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'])
                echo 'Admin';
            else if (isset($_SESSION['loggedUser']))
                echo $_SESSION['loggedUser']->getFirstName()." ".$_SESSION['loggedUser']->getLastName();
            ?>
        </strong>
    </span>
    <ul class="navbar-nav ml-auto">
        <?php
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) 
        {
            echo '<li class="nav-item"><a class="nav-link" href="'.FRONT_ROOT.'Student/ShowAddView">Agregar Alumno</a></li>"';
        }
        ?>        
        <?php
        if ((isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) || isset($_SESSION['loggedUser'])) 
        {
            echo '<li class="nav-item"><a class="nav-link" href="'.FRONT_ROOT.'Student/ShowListView">Listar Alumnos</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="'.FRONT_ROOT.'Login/Logout">Cerrar Sesión</a></li>"';
        }
        ?>
    </ul>
</nav>