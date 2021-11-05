<?php
    use Utils\Utils as Utils;

    if (!isset($_SESSION["loggedUser"]))
        header("location: ../index.php");

    require_once('nav.php');
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container" style="max-width:1360px">
            <h2 class="mb-4">Estudiantes</h2>

            <div class="mb-4">
                <form action="<?php echo FRONT_ROOT ?>Student/FilterByLastName" method="post" class="bg-light-alpha p-4">
                    <div class="input-group input-group-lg col-md-6 mx-auto">
                        <input type="text"  name="nameToFilter" class="form-control mx-3" placeholder="Ingrese apellido del estudiante">
                        <button type="submit" name="button" class="btn btn-dark d-block ">Filtrar</button>
                    </div>
                </form>
            </div>

            <table class="table bg-light-alpha">
                <thead>
                    <th>Legajo</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Género</th>
                    <th>DNI</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Teléfono</th>
                    <th>E-mail</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($studentList as $student) {
                    ?>
                        <tr>
                            <td><?php echo $student->getFileNumber() ?></td>
                            <td><?php echo $student->getFirstName() ?></td>
                            <td><?php echo $student->getLastName() ?></td>
                            <td><?php echo $student->getGender() ?></td>
                            <td><?php echo $student->getDNI() ?></td>
                            <td><?php echo Utils::dateTimeToString($student->getBirthDate()) ?></td>
                            <td><?php echo $student->getPhoneNumber() ?></td>
                            <td><?php echo $student->getEmail() ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</main>