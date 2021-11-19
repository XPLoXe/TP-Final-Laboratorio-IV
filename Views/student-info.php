
<?php
    use Utils\Utils as Utils;

    if (!isset($_SESSION["loggedUser"]))
        header("location: ../index.php");

    require_once('nav.php');
?>

<script>
    function confirmDeleteApplicant() {

        var response = confirm('¿Está seguro de que desea borrar al aplicante?');

        if (response == true)
            return true;
        else
            return false;
    }
</script>

<div class="container emp-profile">
            <form id="info" action="<?php echo FRONT_ROOT ?>Company/ShowInfo" name='info' method='POST' class="bg-light-alpha p-5" >
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                        <?php echo $student->getFirstName() . " " . $student->getLastName()?>
                                    </h5>
                                    <br>
                                    <br>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Información Personal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Postulaciones</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Nombre</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $student->getFirstName() . " " . $student->getLastName(); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $student->getEmail(); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Phone</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $student->getPhoneNumber(); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Profession</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $career->getDescription(); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>DNI</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $student->getDni(); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Legajo</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $student->getFileNumber(); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <?php 
                                if (!empty($jobOffers))
                                {
                                    foreach ($jobOffers as $jobOffer)
                                    { ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Compañía</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $jobOffer->getCompanyName(); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Posición</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $jobOffer->getJobPosition()->getDescription(); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Descripción</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $jobOffer->getDescription(); ?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <?php
                                                if ($jobOffer->isActive())
                                                { ?>
                                                    <div class="col-md-6">
                                                    <label><?php echo '<button class="btn btn-danger mx-2" type="submit" onclick="return confirmDeleteApplicant()" name="jobOfferId" form="deleteApplicant" value=' . $jobOffer->getJobOfferId() . '>Cancelar Postulación</button>';?></label>
                                                    <input type="hidden" value="<?php echo $student->getUserId()?>" name="studentId" form="deleteApplicant">
                                                    </div> <?php
                                                }
                                            ?>
                                            <div class="col-md-6">
                                                <button class="btn-success mx-2 btn" type="submit" name="id" form="info" value="<?php echo $jobOffer->getCompanyId() ?>">Detalles de la Compañía</button>
                                            </div>
                                        </div>
                                    

                                <?php } }
                                    else {?>
                                        <div class="col-md-6">
                                            <label>Usted no aplicó a ninguna Oferta Laboral </label>
                                        </div>
                                    <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
        </div>
        <form id='deleteApplicant' action="<?php echo FRONT_ROOT ?>JobOffer/DeleteApplicant" name='deleteApplicant' method='POST' ></form>
                                
        