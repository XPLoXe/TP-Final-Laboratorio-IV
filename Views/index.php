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
                         <h2>TP Final <br> Bolsa de Trabajo</h2>
                    </header>
                    <form  action="<?php echo FRONT_ROOT ?>Login/Login" method="post" class="login-form bg-dark-alpha p-5 text-white">
                         <div class="form-group">
                              <label for="">Email</label>
                              <input type="text" name="email" class="form-control form-control-lg" placeholder="Insert Email">
                         </div>
                         <div class="form-group">
                              <label for="">Password</label>
                              <input type="text" name="password" class="form-control form-control-lg" placeholder="Insert Password">
                         </div>
                         <button class="btn btn-dark btn-block btn-lg" type="submit">Login</button>
                    </form>
               </div>
          </main>
     </body>
     
</html>
