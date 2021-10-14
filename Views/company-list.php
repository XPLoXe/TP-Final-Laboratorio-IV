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
                    if (!empty($companyList)) { ?>
                        <form id="info" action="<?php echo FRONT_ROOT ?>Company/ShowInfo" name='info' method='POST' class="bg-light-alpha p-5">
                        </form>
                        <form id="edit" action="<?php echo FRONT_ROOT ?>Company/ShowAlterView" name='alter' method='POST' class="bg-light-alpha p-5"></form>
                        <form id="delete" action="<?php echo FRONT_ROOT ?>Company/Delete" name='delete' method='POST' class="bg-light-alpha p-5">
                        </form> <?php
                        foreach ($companyList as $company) {
                            if ($company->isActive()) { ?>
                                <tr>
                                    <td><img style="max-height: 50px" src=<?php echo FRONT_ROOT.IMG_PATH.$company->getLogo() ?> alt="image logo"></img></td>
                                    <td><?php echo $company->getName() ?></td>
                                    <td><?php echo $company->getEmail() ?></td>
                                    <td><?php echo $company->getPhoneNumber();
                                    ?></td>
                                    <td><button class="btn btn-dark" type="submit" name="id" form="info" value='<?php echo $company->getCompanyId() ?>'>Details</button>
                                    <?php
                                    if (Utils\Utils::isAdmin())
                                    {
                                    echo '<button class="btn btn-dark" type= "submit" name="alter" form="edit" value=' . $company->getCompanyId() . '>Edit</button> '; 
                                    echo '<button class="btn btn-dark" type="submit" name="delete" form="delete" value=' . $company->getCompanyId() . '>Delete</button>';
                                    } ?></td>
                                    </form>
                                </tr> <?php }
                        }
                    } else {
                            ?>  <tr>
                                    <td>ERROR: There are no companies</td>
                                </tr>
                    <?php
                    } ?>
                            
                </tbody>
            </table>
        </div>
    </section>
</main>