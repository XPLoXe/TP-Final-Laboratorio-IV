<main class="d-flex align-items-center justify-content-center height-100">
    <div class="content">
        <header class="text-center">
            <h2>TP Final <br> Bolsa de Trabajo</h2>
        </header>
        <form action="<?php echo FRONT_ROOT ?>User/Register" method="post" class="login-form bg-dark-alpha p-5 text-white">
            <div class="form-group">
                <label for="">Ingrese su email</label>
                <input type="text" name="email" class="form-control form-control-lg">
            </div>
            <div class="form-group">
                <label for="">Ingrese su contraseña</label>
                <input type="password" name="password" class="form-control form-control-lg">
            </div>
            <div class="form-group">
                <label for="">Ingrese nuevamente su contraseña</label>
                <input type="password" name="password_confirmation" class="form-control form-control-lg">
            </div>
            <input type="hidden" name="user_role_id" value="<?php echo $studentRoleId ?>"></input>
            <button class="btn btn-dark btn-block btn-lg" type="submit">Enviar</button>
        </form>
    </div>
</main>