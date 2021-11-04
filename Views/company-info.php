<?php
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
            <div class="row justify-content-md-center">
              <p class="text-center"> 
                <b>Fundada en:</b> <?php echo $company->getYearOfFoundation() ?> <br>
                <b>Radicada en:</b> <?php echo $company->getCity() ?> <br> 
              </p>
            </div>
            <div class="row text-center justify-content-md-center mt-4 ">
              <strong><?php echo $company->getDescription() ?></strong>
            </div>
        </div>

      </div>

      <div class="row justify-content-end">
        <div class="col-3 font-weight-bold" ><img src="<?php echo FRONT_ROOT.IMG_PATH ?>tel.png"><?php echo $company->getPhoneNumber()?></div>
        <div class="col-3 font-weight-bold" ><img src="<?php echo FRONT_ROOT.IMG_PATH ?>email.png"><?php echo $company->getEmail()?></div>
      </div>

    </div>
  </section>
</main>

