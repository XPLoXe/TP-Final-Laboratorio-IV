<?php use Utils\Utils as Utils; ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="<?php echo FRONT_ROOT ?>Home/Index"><?php echo utils::getLoggedUserFullName()?></a>

    <?php if (Utils::isAdmin()) { ?>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Home/Index">Inicio</a>
        </li>

        <li class="nav-item dropdown" >
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            Compañías
          </a>
          <div class="dropdown-menu" style="background-color: grey">
            <a class="dropdown-item" style="color: black;" href="<?php echo FRONT_ROOT ?>Company/ShowListView">Listar</a>
            <a class="dropdown-item" style="color: black;" href="<?php echo FRONT_ROOT ?>Company/ShowAddView">Agregar</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            Ofertas Laborales
          </a>
          <div class="dropdown-menu" style="background-color: grey">
            <a class="dropdown-item" style="color: black;" href="<?php echo FRONT_ROOT ?>JobOffer/ShowListView">Listar</a>
            <a class="dropdown-item" style="color: black;" href="<?php echo FRONT_ROOT ?>JobOffer/ShowAddView">Agregar</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            Alumnos
          </a>
          <div class="dropdown-menu" style="background-color: grey">
            <a class="dropdown-item" style="color: black;" href="<?php echo FRONT_ROOT ?>Student/ShowListView">Listar</a>
            <a class="dropdown-item" style="color: black;" href="<?php echo FRONT_ROOT ?>Login/ShowSignupView">Registrar</a>
          </div>
        </li>

      </ul>


    <?php  } else {?>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Home/Index">Inicio</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Company/ShowListView">Compañías</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>JobOffer/ShowListView">Ofertas Laborales</a>
        </li>

      </ul>

    <?php }?>

    <div class="btn mx-2 ml-auto d-block">
      <a href="<?php echo FRONT_ROOT ?>Login/Logout" class="btn mx-2 ml-auto d-block" style="color: white;"> Cerrar Sesión </a>
    </div>
</nav>