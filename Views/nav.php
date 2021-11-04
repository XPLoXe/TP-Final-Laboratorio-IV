<?php use Utils\Utils as Utils; ?>

<div class="container" role="navigation">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="position:relative">
        
        
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="position:absolute;right:10px;">
            <ul class="navbar-nav mr-auto d-flex justify-content-end">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="#">Logo</a>

  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="#">Link 1</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link 2</a>
    </li>

    <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Dropdown link
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Link 1</a>
        <a class="dropdown-item" href="#">Link 2</a>
        <a class="dropdown-item" href="#">Link 3</a>
      </div>
    </li>
  </ul>
</nav>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Compañia <span class="caret"></span></a>
          <ul class="dropdown-menu" style="background-color: #343a40 ;">
            <li><a href="#" style="color: white;">Listar</a></li>
            <li><a href="#" style="color: white;">Agregar</a></li>
            <li><a href="#" style="color: white;">Editar</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Ofertas Laborales <span class="caret"></span></a>
          <ul class="dropdown-menu" style="background-color: #343a40 ;">
            <li><a href="#" style="color: white;">Listar</a></li>
            <li><a href="#" style="color: white;">Agregar</a></li>
            <li><a href="#" style="color: white;">Editar</a></li>
          </ul>
        </li>
        <li><a href="<?php echo FRONT_ROOT ?>Company/ShowListView">Page 2</a></li>
        <li><a href="#">Page 3</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>



<!-- <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <span class="navbar-text">
            <strong>
            <?php
                /* use Utils\Utils as Utils;

                echo Utils::getLoggedUserFullName(); */
            ?>
            </strong>
        </a>
    </span>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="<?php /* echo FRONT_ROOT */ ?>Home/Index">Inicio</a>
        <?php
        /* if (Utils::isAdmin())
            include_once('nav-admin.php'); */
        ?>
        <li class="nav-item"><a class="nav-link" href="<?php /* echo FRONT_ROOT */ ?>JobOffer/ShowListView">Ofertas Laborales</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php /* echo FRONT_ROOT */ ?>Student/ShowListView">Alumnos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php /* echo FRONT_ROOT */ ?>Company/ShowListView">Compañías</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php /* echo FRONT_ROOT */ ?>Login/Logout">Cerrar Sesión</a></li>
    </ul>
</nav> -->

