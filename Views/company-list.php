<?php
require_once 'nav.php';
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">List of companies</h2>

            <form action="<?php echo FRONT_ROOT ?>Company/FilterByName" method="post" class="bg-light-alpha p-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text" name="nameToFilter" class="form-control" placeholder="Ingrese nombre de la compañia">
                        </div>
                    </div>
                </div>
                <button type="submit" name="button" class="btn btn-dark d-block">Filter</button>
            </form>

            <?php if (isset($msgErrorFilter)) echo $msgErrorFilter;  ?>


            <form action="<?php echo FRONT_ROOT ?>Company/ShowInfo" name='getId' method='POST' class="bg-light-alpha p-5">
                <input type='hidden' name='companyId' id='id'>
                <table class="table bg-light-alpha">
                    <thead>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                        <!-- <th>Delete</th> -->
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($companyList)) {
                            foreach ($companyList as $company) {
                                if ($company->isActive()) { ?>
                                    <tr>
                                        <td><img style="max-height: 50px" src=<?php echo FRONT_ROOT.IMG_PATH.$company->getLogo() ?> alt="image logo"></img></td>
                                        <td><?php echo $company->getName() ?></td>
                                        <td><?php echo $company->getEmail() ?></td>
                                        <td><?php echo $company->getPhoneNumber();
                                        } ?></td>
                                        <!-- <form id="edit" action="<?php echo FRONT_ROOT ?>Company/ShowAddview" name='edit' method='POST' class="bg-light-alpha p-5">
                                        </form> -->
                                        <form id="delete" action="<?php echo FRONT_ROOT ?>Company/Delete" name='edit' method='POST' class="bg-light-alpha p-5">
                                            <td><button class="btn btn-dark" type= "submit" name="edit" form="edit" >Edit</button> <button class="btn btn-dark" type="submit" name="delete" form="delete" >Delete</button></td>
                                        </form>
                                        
                                        <!-- <td><input type = "button" alt="asd"></td> -->
                                        
                                        
                                        <!-- <input type="image" src="<?php echo IMG_PATH."Edit.php"?>" name="submit" alt="submit"/>; -->
                                    </tr>
                                <?php }
                        } else {
                                
                                ?><tr><td>There is no companies</td></tr><?php
                                                            } ?>
                                
                                <!-- <input type="image" src="<?php echo ROOT.IMG_PATH."Edit.png" ?>" name="submit" alt="suasdbmit"/>;
                                <button class="btn btn-dark btn-block btn-lg" type="submit">Login</button>
                                <form  action="<?php echo FRONT_ROOT ?>Login/Login" method="post" class="login-form bg-dark-alpha p-5 text-white">
                                    <button class="btn btn-dark btn-block btn-lg" type="submit">Login</button>
                                </form> -->
                    </tbody>
                </table>
            </form>
        </div>
    </section>
</main>