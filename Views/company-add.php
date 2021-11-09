<?php
    if (!isset($_SESSION["loggedUser"]))
        header("location: ../index.php");

    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Agregar compañía</h2>
               <form enctype="multipart/form-data" action="<?php echo FRONT_ROOT ?>Company/Add" method="post" class="bg-light-alpha p-5">
                    <div class="row">                         
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Nombre</strong></label>
                                   <input type="text" name="name" class="form-control" placeholder="Messirve.inc" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Año de fundación</strong></label>
                                   <input type="number" min="1901" max="<?php echo date("Y"); ?>" name="yearOfFoundation" class="form-control" placeholder="1987" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Ciudad</strong></label>
                                   <input type="text" name="city" class="form-control" placeholder="Barcelona" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Email</strong></label>
                                   <input type="email" name="email" class="form-control" placeholder="messirve@OhYeah.inc" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Teléfono</strong></label>
                                   <input type="text" name="phoneNumber" class="form-control" placeholder="0800-MESSI" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Logo</strong></label>
                                   <input type="file" name="logo" accept="image/png" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for=""><strong>Descripción</strong></label>
                                   <textarea id="bio" name="description" class="form-control" style="width: 800px; height: 150px;"  placeholder="We Make Dreams Come True" required></textarea>
                              </div>
                         </div>
                    </div>
                    <button type="submit" name="button"  class="btn btn-success mx-2 ml-auto d-block">Agregar</button>
               </form>
          </div>
     </section>
</main>