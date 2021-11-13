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
          <main class="d-flex align-items-center justify-content-center height-99">
               <div class="content">
                    <header class="text-center">
                         <?php echo $message ?>
                         <h1 class="display-1"><Strong>Bienvenido <?php echo Utils::getLoggedUserFullName() ?> <br> Bolsa de Trabajo</Strong></h1>
                    </header>
               </div>
          </main>
          <br>
          <h2 style="text-align: center;">BTC PRICE: <?php echo $btc?></h2>
          <h2 style="text-align: center;">ETH PRICE: <?php echo $eth?></h2>
          <h2 style="text-align: center;">LTC PRICE: <?php echo $ltc?></h2>
          
     </body>
     
</html>

<?php
    require_once('footer.php');