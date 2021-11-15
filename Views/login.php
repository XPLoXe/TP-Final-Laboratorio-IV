<main class="d-flex align-items-center justify-content-center height-100">
    <div class="content">
        <header class="text-center">
            <h2>TP Final <br> Bolsa de Trabajo</h2>
            <?php echo $message ?>
        </header>
        <form action="<?php echo FRONT_ROOT ?>Login/Login" method="post" class="login-form bg-dark-alpha p-5 text-white">
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" name="email" class="form-control form-control-lg" placeholder="Ingrese su e-mail" required>
            </div>
            <div class="form-group">
                <label for="">Contraseña</label>
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Ingrese su contraseña" required>
            </div>
            <button class="btn btn-dark btn-block btn-lg" type="submit">Iniciar Sesión</button>
            <a class="btn btn-dark btn-block btn-lg" href="<?php echo FRONT_ROOT ?>Login/ShowSignupView">Registrarse</a>
            <a class="btn btn-dark btn-block btn-lg" href="<?php echo FRONT_ROOT ?>Login/ShowSignupView">Registrarse como Usuario</a>
            <a class="btn btn-dark btn-block btn-lg" href="<?php echo FRONT_ROOT ?>Login/ShowSignupCompanyView">Registrarse como Compañía</a>
        </form>
    </div>
</main>