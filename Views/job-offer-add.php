<?php
    if (!isset($_SESSION["loggedUser"]))
        header("location: ../index.php");

    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Agregar Oferta de Trabajo</h2>
               <form enctype="multipart/form-data" action="<?php echo FRONT_ROOT ?>JobOffer/Add" method="post" class="bg-light-alpha p-5">
                    <div class="row">                         
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="job-position">Puesto de trabajo</label>
                                   <select name="jobPositionId" id="job-position" class="form-control" required>
                                   <?php
                                       foreach($jobPositionList as $jobPosition)
                                       {
                                           echo '<option value='.$jobPosition->getJobPositionId().'>'.$jobPosition->getDescription().'</option>';
                                       }
                                    ?>
                                   </select>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="companies">Compañía</label>
                                   <select name="companyId" id="companies" class="form-control" required>
                                       <?php
                                       foreach($companyList as $company)
                                       {
                                           echo '<option value='.$company->getCompanyId().'>'.$company->getName().'</option>';
                                       }
                                       ?>
                                   </select>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Fecha de vencimiento</label>
                                   <input type="date" name="expirationDate" value="<?php echo date('Y-m-d') ?>" min="<?php echo date('Y-m-d'); ?>" max="<?php echo mktime(0, 0, 0, date("m")+3,date("d"),date("Y")) ?>"  class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Descripción</label>
                                   <textarea id="bio" name="description" class="form-control" required></textarea> 
                              </div>
                         </div>
                    </div>
                    <input type="hidden" name="publicationDate" value="<?php echo date('Y-m-d') ?>"></input>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Agregar</button>
               </form>
          </div>
     </section>
</main>