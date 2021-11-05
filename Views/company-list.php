<?php
    use Utils\Utils as Utils;
    
    if (!isset($_SESSION["loggedUser"])) 
        header("location: ../index.php");

    require_once('nav.php');
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container bg-light-alpha p-5" style="max-width:1470px">
           
            <h2 class="mb-4">Compañías</h2>

            <div class="mb-4">
                <form action="<?php echo FRONT_ROOT ?>Company/FilterByName" method="post" class="bg-light-alpha p-4">
                    <div class="input-group input-group-lg col-md-6 mx-auto">
                        <input type="text"  name="nameToFilter" class="form-control mx-3" placeholder="Ingrese nombre de la compañia">
                        <button type="submit" name="button" class="btn btn-dark d-block ">Filtrar</button>
                    </div>
                </form>
            </div>

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
                        {?>
                            <tr class="p-4">
                                <td><img src="data:image/png;base64, <?php echo $company->getLogo() ?>" alt="image logo" width=50px></img></td>
                                <td><?php echo $company->getName() ?></td>
                                <td><?php echo $company->getCity() ?></td>
                                <td><?php echo $company->getPhoneNumber(); ?></td>
                                <td style="max-width:300px" ><?php echo $company->getEmail() ?></td>
                                <td><button class="btn btn-dark" type="submit" name="id" form="info" value='<?php echo $company->getCompanyId() ?>'>Detalles</button>
                                    <?php
                                    if (Utils::isAdmin()) 
                                    {
                                        echo '<button class="btn btn-success" type= "submit" name="companyId" form="edit" value=' . $company->getCompanyId() . '>Editar</button> ';
                                        echo '<button class="btn btn-danger" type="submit" onclick="return confirmDelete()" name="companyId" form="delete" value='.$company->getCompanyId().'>Eliminar</button>';
                                    } ?></td>
                                </form>
                            </tr> 
                        <?php 
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