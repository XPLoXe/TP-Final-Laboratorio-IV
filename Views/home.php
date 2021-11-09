<!DOCTYPE html>

<?php
    use Utils\Utils as Utils;
    require_once('nav.php');
?>

<html>
     <head>
          <link rel="stylesheet" type="text/css" href="css\estilos.css">
     </head>
     <body>
          <br>
          <h2 style="text-align: center;">BTC PRICE: <?php echo $btc?></h2>
          <h2 style="text-align: center;">ETH PRICE: <?php echo $eth?></h2>
          <h2 style="text-align: center;">LTC PRICE: <?php echo $ltc?></h2>
          <main class="d-flex align-items-center justify-content-center height-100">
               <div class="content">
                    <header class="text-center">
                         <?php echo $message ?>
                         <h1>Bienvenido <?php echo Utils::getLoggedUserFullName() ?> <br> Bolsa de Trabajo</h1>
                    </header>
               </div>
          </main>
     </body>
     
</html>

<?php
    require_once('footer.php');