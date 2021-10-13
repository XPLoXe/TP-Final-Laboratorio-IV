<!DOCTYPE html>

<?php
    require_once('nav.php');
?>

<html>
     <head>
          <link rel="stylesheet" type="text/css" href="css\estilos.css">
     </head>
     <body>
          <main class="d-flex align-items-center justify-content-center height-100">
               <div class="content">
                    <header class="text-center">
                         <h1>Bienvenido <?php echo Utils\Utils::getLoggedUserFullName() ?> <br> Bolsa de Trabajo</h1>
                    </header>
               </div>
          </main>
     </body>
     
</html>

<?php
    require_once('footer.php');
?>