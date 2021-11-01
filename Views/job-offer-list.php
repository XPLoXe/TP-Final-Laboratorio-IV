<?php
    use Utils\Utils as Utils;
    
    if (!isset($_SESSION["loggedUser"])) 
        header("location: ../index.php");

    require_once('nav.php');
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container" style="max-width:1280px">    
            <h2 class="mb-4">Ofertas de trabajo</h2>
            <form action="<?php echo FRONT_ROOT ?>JobOffer/FilterByName" method="post" class="bg-light-alpha p-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text" name="jobPositionToFilter" class="form-control" placeholder="Ingrese posicion de trabajo">
                        </div>
                    </div>
                </div>
                <button type="submit" name="button" class="btn btn-dark d-block">Filtrar</button>
            </form>

            <?php if (isset($msgErrorFilter)) echo $msgErrorFilter;  ?>
            <script>
                function confirmDelete() {

                    var response = confirm('¿Está seguro de que desea borrar la compañia ?');

                    if (response == true)
                        return true;
                    else
                        return false;
                }
            </script>

            <?php 
                
                if (!empty($jobOfferList)) 
                { ?>
                    <form id="edit" action="<?php echo FRONT_ROOT ?>Company/ShowEditView" name='edit' method='POST' class="bg-light-alpha p-5"></form>
                    <form id="delete" action="<?php echo FRONT_ROOT ?>Company/Delete" name='delete' method='POST' class="bg-light-alpha p-5"></form>
                    <form id="aplicate" action="<?php echo FRONT_ROOT ?>Company/Apply" name='apply' method='POST' class="bg-light-alpha p-5"></form>
                    <?php
                    foreach ($jobOfferList as $jobOffer) 
                    {
                        if ($jobOffer->isActive()) //We have to see if this is fine
                        { ?>
                            <div class="container">

                                <table class="table bg-light-alpha">

                                    <tr>
                                        <td>
                                            <div class="container"> 
                                                <h3><?php echo $jobOffer->getCompany()->getName() ?></h3>
                                                <h2><?php echo $jobOffer->getCompany()->getCity() ?></h2>
                                                <h1><?php echo $jobOffer->getJobPosition()->getDescription() ?></h1>
                                                <h1><?php echo "Publicado hace X días" ?></h1>
                                                <h1><?php echo 'Vence el día '.$jobOffer->getExpirationDate()->format('d-m-Y').''?></h1>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="container"> 
                                                <?php echo $jobOffer->getDescription() ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <?php 
                                                if(!Utils::isAdmin())
                                                    echo '<button class="btn btn-dark" type="submit" name="jobOfferId" form="apply" value='. $jobOffer->getJobOfferId() .'>Postularse</button>';
                        
                                                if (Utils::isAdmin())
                                                {
                                                    echo '<button class="btn btn-dark" type= "submit" name="jobOfferId" form="edit" value=' . $jobOffer->getJobOfferId() . '>Editar</button> ';
                                                    echo '<button class="btn btn-dark" type="submit" onclick="return confirmDelete()" name="jobOfferId" form="delete" value=' . $jobOffer->getJobOfferId() . '>Eliminar</button>';
                                                }      
                                            ?>
                                        
                                        </td>
                                    </tr>

                                </table>

                            </div>

                        <?php 
                        } 

                    }

                }
            ?>
        </div>
    </section>
</main>
