<?php

use Utils\Utils as Utils;

if (!Utils::isUserLoggedIn())
    header("location: ../index.php");
else
    $isAdmin = (Utils::isAdmin()) ?: false;

require_once('nav.php');
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container bg-light-alpha p-5">

            <h2 class="mb-4">Ofertas laborales</h2>

            <div class="mb-4">
                <form action="<?php echo FRONT_ROOT ?>JobOffer/FilterByName" method="post" class="bg-light-alpha p-4">
                    <div class="input-group input-group-lg col-md-6 mx-auto">
                        <input type="text" name="nameToFilter" class="form-control mx-3" placeholder="Ingrese puesto de trabajo">
                        <button type="submit" name="button" class="btn btn-dark d-block ">Filtrar</button>
                    </div>
                </form>
            </div>

            <?php
            if (isset($msgErrorFilter)) echo $msgErrorFilter;

            function daysBetweenDates($initialDay, $finalDay)
            {
                $days = (strtotime($initialDay) - strtotime($finalDay)) / 86400;
                $days = abs($days);
                $days = floor($days);
                return $days;
            }
            ?>
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
            if (!empty($jobOfferList)) { ?>
                <form id="edit" action="<?php echo FRONT_ROOT ?>JobOffer/ShowEditView" name='edit' method='POST'></form>
                <form id="delete" action="<?php echo FRONT_ROOT ?>JobOffer/Delete" name='delete' method='POST'></form>
                <form id="aplicate" action="<?php echo FRONT_ROOT ?>JobOffer/Apply" name='apply' method='POST'></form>
                <?php
                foreach ($jobOfferList as $jobOffer) {
                ?>
                    <table class="table bg-light-alpha">

                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col text-center">
                                        <h1><?php echo $jobOffer->getCompany()->getName() ?></h1>
                                        <h4><?php echo $jobOffer->getCompany()->getCity() ?></h4>
                                    </div>
                                    <div class="col d-flex">
                                        <h3 class="my-auto ml-auto mb-3"><?php echo $jobOffer->getJobPosition()->getDescription() ?></h3>
                                    </div>
                                    <div class="col align-self-end text-right">
                                        <h6><?php echo 'Publicado hace ' . daysBetweenDates($jobOffer->getPublicationDate()->format('Y-m-d'), date('Y-m-d')) . ' días' ?></h3>
                                            <h6><?php echo 'Vence el día ' . $jobOffer->getExpirationDate()->format('d-m-Y') . '' ?></h3>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="col">
                                    <?php echo $jobOffer->getDescription() ?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="float-right">
                                    <?php
                                    if (!Utils::isAdmin())
                                        echo '<button class="btn btn-success mx-2" type="submit" name="jobOfferId" form="apply" value=' . $jobOffer->getJobOfferId() . '>Postularse</button>';

                                    if (Utils::isAdmin()) {
                                        echo '<button class="btn btn-dark mx-2" type= "submit" name="jobOfferId" form="edit" value=' . $jobOffer->getJobOfferId() . '>Editar</button> ';
                                        echo '<button class="btn btn-danger mx-2" type="submit" onclick="return confirmDelete()" name="jobOfferId" form="delete" value=' . $jobOffer->getJobOfferId() . '>Eliminar</button>';
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
            <?php
                }
            }
            ?>
        </div>
    </section>
</main>