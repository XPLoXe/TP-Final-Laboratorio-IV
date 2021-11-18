<?php

use Utils\Utils;

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
                                   <label for=""><strong>Nombre</strong></label>
                                   <input type="text" name="name" class="form-control" value="<?php echo $company->getName() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Año de fundación</strong></label>
                                   <input type="number" name="yearOfFoundation" min="1901" max="<?php echo date("Y"); ?>" class="form-control" value="<?php echo $company->getYearOfFoundation() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Ciudad</strong></label>
                                   <input type="text" name="city" class="form-control" value="<?php echo $company->getCity() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Email</strong></label>
                                   <input type="email" name="email" class="form-control" value="<?php echo $company->getEmail() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Teléfono</strong></label>
                                   <input type="text" name="phoneNumber" class="form-control" value="<?php echo $company->getPhoneNumber() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Logo</strong></label>
                                   <img style="max-height: 50px" src="data:image/png;base64, <?php echo $company->getLogo() ?>"></img>
                                   <input type="file" name="logo" accept=".jpg, jpeg, image/png, image/gif" class="form-control" value="<?php echo FRONT_ROOT.IMG_PATH.$company->getLogo() ?>">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Descripción</strong></label> <strong></strong>
                                   <textarea id="bio" name="description" class="form-control" style="width: 800px; height: 150px;" ><?php echo $company->getDescription() ?></textarea>
                              </div>
                         </div>
                    </div>
                    <?php if (Utils::isAdmin()){?>
                         <br>
                         <div class="row">
                              <div class="col-lg-4">
                                   <div class="form-group">
                                        <label for=""><strong>Contraseña</strong></label>
                                        <input type="text" name="phoneNumber" class="form-control" value="<?php echo $company->getPassword() ?>">
                                   </div>
                              </div>
                              <div class="col-lg-4">
                                   <div class="form-group">
                                        <label for=""><strong>Estado</strong></label>
                                        <div>
                                             <input type="radio" id="Aprobada" value="true" checked>
                                             <label>Aprobada</label>
                                        </div>
                                        <div>
                                             <input type="radio" id="Desaprobada" value="false">
                                             <label>Desaprobada</label>
                                        </div>
                                   </div>
                              </div>
                              
                         </div>
                    <?php }?>
                    
                    <button type="submit" name="id" value="<?php echo $company->getCompanyId() ?>" class="btn btn-dark ml-auto d-block">Aceptar</button>
               </form>
          </div>
     </section>
</main>