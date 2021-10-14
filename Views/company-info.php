<?php
  require_once('nav.php');
  if (!isset($_SESSION["loggedUser"])) 
  {
    require_once('login.php');
  }
?>

<!DOCTYPE html>
<html>
<title>Company-Info</title>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<div class="container">
  <div class="row align-items-start ">
    <div class="col">
    <div>
      <h1><b><?php echo $company->getName() ?></b></h1>
      <img src="<?php echo FRONT_ROOT.IMG_PATH.$company->getLogo() ?>" style="width:75%; max-height:75%" > 
      <br>
      <br><h2 style="padding: 1%;"><b>Contact Info:</b></h2>
      <p>
        <img src="<?php echo FRONT_ROOT.IMG_PATH ?>tel.png">
        <?php echo $company->getPhoneNumber(). ""?>
        <br>
        <img src="<?php echo FRONT_ROOT.IMG_PATH ?>email.png"> <?php echo $company->getEmail()?>
      </p>
    </div>
    </div>
    <div class="col" style="font-size: x-large; text-align:center; margin-top: 35px">
      <br>
      <b>Fundada en:</b> <?php echo $company->getYearFoundation() ?> <br>
      <b>Radicada en:</b> <?php echo $company->getCity() ?> <br> 
      <br>
      <p><strong><?php echo $company->getDescription() ?></strong></p>
    </div>
  </div>
</div>