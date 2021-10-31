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
                                   <label for="">Puesto de trabajo</label>
                                   <input type="text" name="jobPositionDescription" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Nombre de la Compañia</label>
                                   <input type="text" name="companyName" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Descripción</label>
                                   <textarea id="bio" name="jobOfferDescription" class="form-control" required></textarea> 
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Dia de expiracion</label>
                                   <input type="date" name="expirationDate" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" max="<?php echo mktime(0, 0, 0, date("m")+3,date("d"),date("Y")) ?>"  class="form-control" required>
                              </div>
                         </div>
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Agregar</button>
               </form>
          </div>
     </section>
</main>