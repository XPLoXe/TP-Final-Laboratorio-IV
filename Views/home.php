<!DOCTYPE html>

<?php
    require_once('nav.php');
    if (!isset($_SESSION["loggedUser"])) {
        session_start();

        require_once('index.php');
    }
?>

<html>
     <head>
          <link rel="stylesheet" type="text/css" href="css\estilos.css">
     </head>
     <body>
          <main class="d-flex align-items-center justify-content-center height-100">
               <div class="content">
                    <header class="text-center">
                         <h1>Bienvenido <?php echo $_SESSION["loggedUser"]->getFirstName();?> <br> Bolsa de Trabajo</h1>
                    </header>
               </div>
          </main>
     </body>
     
</html>

<?php
    require_once('footer.php');
?>