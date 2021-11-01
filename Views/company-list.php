<?php
    use Utils\Utils as Utils;
    
    if (!isset($_SESSION["loggedUser"])) 
        header("location: ../index.php");

    require_once('nav.php');
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container" style="max-width:1360px">
            <h2 class="mb-4">Compañías</h2>
            <form action="<?php echo FRONT_ROOT ?>Company/FilterByName" method="post" class="bg-light-alpha p-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text" name="nameToFilter" class="form-control" placeholder="Ingrese nombre de la compañia">
                        </div>
                    </div>
                </div>
                <button type="submit" name="button" class="btn btn-dark d-block">Filtrar</button>
            </form>
            <?php if (isset($msgErrorFilter)) echo $msgErrorFilter;  ?>
            <script type="text/javascript">
                function confirmDelete() {

                    var response = confirm('¿Está seguro de que desea borrar la compañia ?');

                    if (response == true)
                        return true;
                    else
                        return false;
                }
            </script>

            <table class="table bg-light-alpha">
                <thead>
                    <th></th>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Teléfono</th>
                    <th>E-mail</th>
                    <th>Acciones</th>
                    <!-- <th>Delete</th> -->
                </thead>
                <tbody>
                    <?php
                    if (!empty($companyList)) 
                    { ?>
                        <form id="info" action="<?php echo FRONT_ROOT ?>Company/ShowInfo" name='info' method='POST' class="bg-light-alpha p-5">
                        </form>
                        <form id="edit" action="<?php echo FRONT_ROOT ?>Company/ShowEditView" name='edit' method='POST' class="bg-light-alpha p-5"></form>
                        <form id="delete" action="<?php echo FRONT_ROOT ?>Company/Delete" name='delete' method='POST' class="bg-light-alpha p-5">
                        </form>
                        <?php
                        foreach ($companyList as $company) 
                        {
                            if ($company->isActive()) 
                            { ?>
                                <tr>
                                    <td><img src="data:image/png;base64, <?php echo $company->getLogo() ?>" alt="image logo" width=50px></img></td>
                                    <td><?php echo $company->getName() ?></td>
                                    <td><?php echo $company->getCity() ?></td>
                                    <td><?php echo $company->getPhoneNumber(); ?></td>
                                    <td style="max-width:200px" ><?php echo $company->getEmail() ?></td>
                                    <td><button class="btn btn-dark" type="submit" name="id" form="info" value='<?php echo $company->getCompanyId() ?>'>Detalles</button>
                                        <?php
                                        if (Utils::isAdmin()) 
                                        {
                                            echo '<button class="btn btn-dark" type= "submit" name="edit" form="edit" value=' . $company->getCompanyId() . '>Editar</button> ';
                                            echo '<button class="btn btn-dark" type="submit" onclick="return confirmDelete()" name="delete" form="delete" value=' . $company->getCompanyId() . '>Eliminar</button>';
                                        } ?></td>
                                    </form>
                                </tr> <?php 
                            }
                        } 
                    } else 
                    { ?>        <tr>
                                <td>ERROR: There are no companies</td>
                                </tr>
                    <?php
                        } 
                     ?>

                </tbody>
            </table>
        </div>
    </section>
</main>