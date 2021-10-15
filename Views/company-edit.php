<?php
    if (!isset($_SESSION["loggedUser"])) 
        header("location: ../index.php");

    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Editar Compañía</h2>
               <form enctype="multipart/form-data" action="<?php echo FRONT_ROOT ?>Company/Edit" method="post" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Name</label>
                                   <input type="text" name="name" class="form-control" value="<?php echo $company->getName() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Year of foundation</label>
                                   <input type="number" name="yearFoundation" class="form-control" value="<?php echo $company->getYearFoundation() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">City</label>
                                   <input type="text" name="city" class="form-control" value="<?php echo $company->getCity() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Description</label>
                                   <input type="text" name="description" class="form-control" value="<?php echo $company->getDescription() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Email</label>
                                   <input type="email" name="email" class="form-control" value="<?php echo $company->getEmail() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Phone Number</label>
                                   <input type="text" name="phoneNumber" class="form-control" value="<?php echo $company->getPhoneNumber() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Logo</label>
                                   <img style="max-height: 50px" src=<?php echo $company->getLogo() ?> alt="image logo"></img>
                                   <input type="file" name="logo" accept=".jpg, jpeg, image/png, image/gif" value="" class="form-control">
                              </div>
                         </div>
                    </div>
                    <button type="submit" name="id" value="<?php echo $company->getCompanyId() ?>" class="btn btn-dark ml-auto d-block">Aceptar</button>
               </form>
          </div>
     </section>
</main>