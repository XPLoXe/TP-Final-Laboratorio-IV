<?php
  require_once('nav.php');
  
?>

<!DOCTYPE html>
<html>
<title>Company-Info</title>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <link rel="stylesheet" type="text/css" href="css\estilos.css">
  <!-- <link rel="stylesheet2" href="<?php echo CSS_PATH?>w3.css">
  <link rel="stylesheet2" href="tp-final-laboratorio-iv\Views\css\w3.css">
  <link rel="stylesheet2" href="css\font-awesome.min.css"> -->
  <!-- <style>
    * {
      box-sizing: border-box;
    }

    /* Create two equal columns that floats next to each other */
    .column {
      float: left;
      width: 50%;
      padding: 10px;
      height: 300px; /* Should be removed. Only for demonstration */
    }

    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }
  </style> -->
</head>

<body class="w3-content" >
  

<!-- First Grid: Logo & About -->
<div class="w3-row">
  <div class="w3-half w3-container">
    <h1 class="w3-jumbo"><b><?php echo $company->getName() ?></b></h1>
  </div>
  
</div>

<!-- Second Grid: Resent -->
<div class="w3-row">
  <div class="w3-half w3-container">
    <img src="<?php echo FRONT_ROOT.IMG_PATH.$company->getLogo() ?>" style="width:100%; max-height:300px" > 
  </div>
  <div class="w3-half w3-container w3-xlarge w3-text-black">
    <br>
    <p class="container" ><?php echo $company->getDescription() ?></p>
  </div>
</div>

<!-- Footer -->
<div class="w3-row w3-section">
  <div class="w3-third w3-container w3-light blue w3-large" style="height:100px; width:800px">
    <h2><b>Contact Info:</b></h2>
    <br>
    <p>
      <img src="<?php echo FRONT_ROOT.IMG_PATH ?>tel.png">
      <!-- <i class="fa fa-map-marker" style="width:30px"></i> -->  <?php echo $company->getPhoneNumber(). "  "?>
      <br>
      <img src="<?php echo FRONT_ROOT.IMG_PATH ?>email.png"> <?php echo $company->getEmail()?>
      <!-- <i class="fa fa-phone" style="width:30px"></i> --> 
      <!-- <i class="fa fa-envelope" style="width:30px"> </i> <?php echo $company->getPhoneNumber(). " --"?> </p> -->
  </div>
  <!-- <div class="w3-third w3-center w3-large w3-dark-grey w3-text-white" style="height:250px">
    <h2>Contact Us</h2>
    <p>If you have an idea.</p>
    <p>What are you waiting for?</p>
  </div>
  <div class="w3-third w3-center w3-large w3-grey w3-text-white" style="height:250px">
    <h2>Like Us</h2>
    <i class="w3-xlarge fa fa-facebook-official"></i><br>
    <i class="w3-xlarge fa fa-pinterest-p"></i><br>
    <i class="w3-xlarge fa fa-twitter"></i><br>
    <i class="w3-xlarge fa fa-flickr"></i><br>
    <i class="w3-xlarge fa fa-linkedin"></i>
  </div> -->
</div>
<br>

</body>
</html>

<!-- <!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Page 1</title>
    <link rel="stylesheet" type="text/css" href="css\nicepage.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css\Page-1.css" media="screen">
    <script class="u-script" type="text/javascript" src="js\jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="js\nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 3.27.0, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": ""
    }</script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Page 1">
    <meta property="og:type" content="website">
</head>
<body class="u-body"><header class="u-clearfix u-header u-header" id="sec-3db5"><div class="u-clearfix u-sheet u-sheet-1"></div></header>
    <section class="u-clearfix u-section-1" id="sec-c0d3">
      <div class="u-clearfix u-sheet u-sheet-1">
        <h1 class="u-text u-text-default u-text-1">Sample Headline</h1>
        <div class="u-clearfix u-expanded-width u-gutter-10 u-layout-wrap u-layout-wrap-1">
          <div class="u-layout">
            <div class="u-layout-row">
              <div class="u-size-14-lg u-size-14-xl u-size-29-sm u-size-29-xs u-size-60-md">
                <div class="u-layout-col">
                  <div class="u-container-style u-layout-cell u-left-cell u-size-60 u-layout-cell-1" src="">
                    <div class="u-container-layout u-valign-middle u-container-layout-1">
                      <img class="u-expanded-width u-image u-image-1" src="images/1.svg" data-image-width="1080" data-image-height="1080">
                    </div>
                  </div>
                </div>
              </div>
              <div class="u-size-31-sm u-size-31-xs u-size-46-lg u-size-46-xl u-size-60-md">
                <div class="u-layout-col">
                  <div class="u-size-30">
                    <div class="u-layout-row">
                      <div class="u-align-left u-container-style u-grey-15 u-layout-cell u-size-30 u-layout-cell-2">
                        <div class="u-container-layout u-valign-top u-container-layout-2">
                          <h3 class="u-text u-text-2">We are the experts in quality business strategy</h3>
                        </div>
                      </div>
                      <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-30 u-layout-cell-3">
                        <div class="u-container-layout u-valign-top u-container-layout-3">
                          <p class="u-text u-text-3">Sample text. Click to select the text box. Click again or double click to start editing the text.&nbsp;Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="u-size-30">
                    <div class="u-layout-row">
                      <div class="u-align-left u-container-style u-layout-cell u-size-30 u-layout-cell-4">
                        <div class="u-container-layout u-valign-top u-container-layout-4">
                          <p class="u-text u-text-4">Sample text. Click to select the text box. Click again or double click to start editing the text.&nbsp;Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                        </div>
                      </div>
                      <div class="u-align-left u-container-style u-grey-15 u-layout-cell u-right-cell u-size-30 u-layout-cell-5">
                        <div class="u-container-layout u-valign-top u-container-layout-5">
                          <p class="u-text u-text-5">Sample text. Click to select the text box. Click again or double click to start editing the text.&nbsp;Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
 -->


<!-- <html>
    <head>
        <h1 style="text-align: center;"><?php echo $company->getName()?></h1>
    </head>
    <body>
        <div style="font-size: 150%; ">Año de fundación:</div>
    </body>
</html> -->





<!-- style="font-family:'Times New Roman', Times, serif" -->

<!-- <table class="table bg-light-alpha">
    <thead>
        <th>Logo</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Actions</th>
        <th>Delete</th> 
    </thead>
    <tbody> 
    </tbody>
</table> -->