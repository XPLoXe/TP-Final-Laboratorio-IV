<?php
  require_once('nav.php');
  
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
      <h2 style="padding: 1%;"><b>Contact Info:</b></h2>
      <p>
        <img src="<?php echo FRONT_ROOT.IMG_PATH ?>tel.png">
        <?php echo $company->getPhoneNumber(). "  "?>
        <br>
        <img src="<?php echo FRONT_ROOT.IMG_PATH ?>email.png"> <?php echo $company->getEmail()?>
        <?php echo $company->getPhoneNumber(). " --"?> 
      </p>
    </div>
    </div>
    <div class="col">
      <br>
      <p style="font-size: x-large; text-align:center; margin-top: 35px;"><?php echo $company->getDescription() ?></p>
    </div>
  </div>
</div>