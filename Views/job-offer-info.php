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

                    var response = confirm('¿Está seguro de que desea borrar la oferta laboral?');

                    if (response == true)
                        return true;
                    else
                        return false;
                }

                function confirmDeleteApplicant() {

                    var response = confirm('¿Está seguro de que desea borrar al aplicante?');

                    if (response == true)
                        return true;
                    else
                        return false;
                }

                function confirmAcceptApplicant() {

                    var response = confirm('¿Está seguro de que desea aceptar al aplicante?');

                    if (response == true)
                        return true;
                    else
                        return false;
                }
                
            </script>

           
                <form id="edit" action="<?php echo FRONT_ROOT ?>JobOffer/ShowEditView" name='edit' method='POST'></form>
                <form id="delete" action="<?php echo FRONT_ROOT ?>JobOffer/Delete" name='delete' method='POST'></form>
                <form id="apply" action="<?php echo FRONT_ROOT ?>JobOffer/Apply" name='apply' method='POST'></form>
                <form id="generatePDF" action="<?php echo FRONT_ROOT ?>JobOffer/GeneratePDF" name='generatePDF' method='POST' target='_blank'></form>
                
                <div class="bg-light-alpha">
                <table class="table">

                        <?php if (Utils::isAdmin() || Utils::isCompany()) {?>                       
                        <tr>
                            <td>
                                <div class="d-flex justify-content-around">
                                    <?php
                                        echo '<button class="btn btn-warning mx-2" type= "submit" name="jobOfferId" form="generatePDF" value=' . $jobOffer->getJobOfferId() . '>Generar PDF</button> ';
                                        echo '<button class="btn btn-success mx-2" type= "submit" name="jobOfferId" form="edit" value=' . $jobOffer->getJobOfferId() . '>Editar</button> ';
                                        echo '<button class="btn btn-danger mx-2" type="submit" onclick="return confirmDelete()" name="jobOfferId" form="delete" value=' . $jobOffer->getJobOfferId() . '>Eliminar</button>';
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col text-center">
                                        <h1><?php echo $jobOffer->getCompany()->getName() ?></h1>
                                        <h4><?php echo $jobOffer->getCompany()->getCity() ?></h4>
                                    </div>
                                    <div class="col d-flex text-center ">
                                        <h3 class="my-auto ml-auto"><?php echo $jobOffer->getJobPosition()->getDescription() ?></h3>
                                    </div>
                                    <div class="col align-self-end text-right">
                                        <h6><?php echo 'Publicado hace ' . daysBetweenDates($jobOffer->getPublicationDate()->format('Y-m-d'), date('Y-m-d')) . ' días' ?></h6>
                                        <?php

                                            if ($jobOffer->getExpirationDate()->format('Y-m-d') > date('Y-m-d'))
                                                echo '<h6> Vence el día ' . $jobOffer->getExpirationDate()->format('d-m-Y') . '</h6>' ;
                                            else
                                                echo '<h6 style="color: red"> Vencio el día ' . $jobOffer->getExpirationDate()->format('d-m-Y') . '</h6>' ;

                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php if(!empty($jobOffer->getFlyer())) {?>
                        <tr>
                            <td>
                                <div class="col">
                                    <?php echo '<a class="btn btn-success" href="data:image/png;base64,'.$jobOffer->getFlyer().'"  alt="image flyer" download="flyer.png">Descargar Flyer</a>'; ?>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td>
                                <div class="col">
                                    <?php echo $jobOffer->getDescription() ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="col">
                                    <?php
                                    
                                    if (Utils::isStudent() && !in_array($jobOffer->getJobOfferId(), $applications))
                                    {
                                        echo '<button class="btn btn-success mx-2" type="submit" name="jobOfferId" form="apply" value='.$jobOffer->getJobOfferId().'>Postularse</button>';
                                    }
                                    if(Utils::isAdmin() || Utils::isCompany())
                                    { 
                                        if (!empty($applicants))
                                        {   echo '<div class="text-center text-white mt-2"><h3><strong> Postulantes </h3></strong></div>';
                                            foreach($applicants as $student)
                                            {
                                            ?>
                                                <form id="deleteApplicant" action="<?php echo FRONT_ROOT ?>JobOffer/DeleteApplicant" name='deleteApplicant' method='POST'>
                                                    <input type="hidden" value="<?php echo $student->getUserId()?>" name="studentId">
                                                </form>

                                                <form id="studentInfo" action="<?php echo FRONT_ROOT ?>Student/ShowInfoView" name='studentInfo' method='POST'></form>

                                                <div >

                                                    <div class="d-inline-flex p-2 pl-5"><h5><?php echo $student->getLastName()." ".$student->getFirstName()." <strong class='h4'>|</strong> ".$student->getEmail(); ?></h5></div>
                                                    
                                                    <div class="d-inline-flex float-sm-right p-2">
                                                        <button class="btn btn-danger mx-2" type="submit" onclick="return confirmDeleteApplicant()" name="jobOfferId" form="deleteApplicant" value='<?php echo $jobOffer->getJobOfferId()?>'>Eliminar</button>
                                                        <button class="btn btn-info mx-2" type="submit" name="studentInfo" form="studentInfo" value=' <?php echo $student->getUserId()?>'>Información</button>
                                                        <?php if (Utils::isCompany()) {?>
                                                            <button class="btn btn-success mx-2" type="submit" onclick="return confirmAcceptApplicant()" name="jobOfferId" form="acceptApplicant" value='<?php echo $jobOffer->getJobOfferId()?>'>Aceptar</button>
                                                            <form id="acceptApplicant" action="<?php echo FRONT_ROOT ?>JobOffer/AcceptApplicant" name='acceptApplicant' method='POST'>
                                                                <input type="hidden" value="<?php echo $student->getUserId()?>" name="studentId">
                                                                <input type="hidden" value="<?php echo $jobOffer->getCompanyName()?>" name="companyName">
                                                            </form>
                                                        <?php }?>
                                                    </div>

                                                </div>
                                                <br>
                                            <?php
                                            }
                                        }
                                        else
                                        {
                                            echo "<strong style='color:red; font-size:medium;'> Ningun estudiante se postulo a esta oferta de trabajo </strong>";
                                        }
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                </table>
                </div>
        </div>
    </section>
</main>