<?php use Utils\Utils as Utils; ?>


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
        <div class="nav-item dropdown-menu mt-1" style="background-color: #343a40">
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Company/ShowListView">Listar</a>
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Company/ShowAddView">Agregar</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          Ofertas Laborales
        </a>
        <div class="dropdown-menu mt-1" style="background-color: #343a40">
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>JobOffer/ShowListView">Listar</a>
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>JobOffer/ShowAddView">Agregar</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          Alumnos
        </a>
        <div class="dropdown-menu mt-1" style="background-color: #343a40">
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Student/ShowListView">Listar</a>
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Login/ShowSignupView">Registrar</a>
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>JobOffer/ShowApplicationsView">Postulaciones</a>
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

      <li class="nav-item">
        <a class="nav-link" href="<?php echo FRONT_ROOT ?>Student/ShowInfoView">Información Personal</a>
      </li>


    </ul>

  <?php }?>

  <div class="btn mx-2 ml-auto d-block">
    <a href="<?php echo FRONT_ROOT ?>Login/Logout" class="btn mx-2 ml-auto d-block" style="color: white;"> Cerrar Sesión </a>
  </div>

</nav>