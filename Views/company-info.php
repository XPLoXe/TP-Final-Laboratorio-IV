<?php

use Utils\Utils;

if (!isset($_SESSION["loggedUser"])) 
        header("location: ../index.php");

    require_once('nav.php');
?>

<main class="py-5">
  <section id="listado">
    <div class="container bg-light-alpha p-4" >
      <div class="row">

        <div class="col-6">
            <div class="row justify-content-center mb-4 ">
              <h1><b><?php echo $company->getName() ?></b></h1>
            </div>
            <div class="row justify-content-center">
              <figure class="figure">
                <img src="data:image/png;base64, <?php echo $company->getLogo() ?>" class="figure-img img-fluid rounded" style="width:450px; height:350px">
              </figure>
            </div>
        </div>

        <div class="col">
            <div class="row d-flex justify-content-md-center">
              <h4 class="text-center"> 
                <strong>Fundada en:&nbsp</strong><?php echo $company->getYearOfFoundation() ?> <br><br>
                <strong>Radicada en:&nbsp</strong> <?php echo $company->getCity() ?> <br> 
              </h4>
            </div>
            <div class="row d-flex">
              <strong class="text-center justify-content-md-center mt-4"><?php echo $company->getDescription() ?></strong>
            </div>
            <?php 
            if (Utils::isCompany() || Utils::isAdmin())
            {?>
              <div class="row d-flex text-center justify-content-md-center pt-3">
                <button class="btn btn-success btn-primary btn-lg " type= "submit" name="companyId" form="edit" value="<?php echo $company->getCompanyId() ?>">Editar</button>
              </div>
            <?php 
            }                                
            ?>
        </div>

      </div>

      <div class="row d-flex justify-content-around font-weight-bold">
        <div class="col-6"><h5> <img src="<?php echo FRONT_ROOT.IMG_PATH ?>tel.png">&nbsp&nbsp&nbsp<?php echo $company->getPhoneNumber()?></h5></div>
        <div class="col-6"><h5> <img src="<?php echo FRONT_ROOT.IMG_PATH ?>email.png">&nbsp&nbsp&nbsp<?php echo $company->getEmail()?></h5></div>
        
      </div>
        
      
      <form id="edit" action="<?php echo FRONT_ROOT ?>Company/ShowEditView" name='edit' method='POST'></form>

      </div>

    </div>
  </section>
</main>

