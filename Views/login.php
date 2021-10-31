<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="css\estilos.css">
</head>

<body>
    <main class="d-flex align-items-center justify-content-center height-100">
        <div class="content">
            <header class="text-center">
                <h2>TP Final <br> Bolsa de Trabajo</h2>
                <?php echo $message ?>
            </header>
            <form action="<?php echo FRONT_ROOT ?>Login/Login" method="post" class="login-form bg-dark-alpha p-5 text-white">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control form-control-lg" placeholder="Ingrese su e-mail">
                </div>
                <div class="form-group">
                    <label for="">Contraseña</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Ingrese su contraseña">
                </div>
                <button class="btn btn-dark btn-block btn-lg" type="submit">Iniciar Sesión</button>
                <a class="btn btn-dark btn-block btn-lg" href="<?php echo FRONT_ROOT ?>Login/ShowSignupView">Registrarse</a>
            </form>
        </div>
    </main>
</body>

</html>