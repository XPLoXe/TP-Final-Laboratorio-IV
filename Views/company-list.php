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
                            <label for="">Filter by name</label>
                            <input type="text" name="nameToFilter" class="form-control" placeholder="Insert Company Name">
                        </div>
                    </div>
                </div>
                <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Filter</button>
            </form>

            <?php if (isset($msgErrorFilter)) echo $msgErrorFilter; ?>

            <script>
                function selectCompanyId(companyId) {
                    document.getId.id.value = $(this).closest('tr').attr('id');
                    document.getElementsByName('getId')[0].submit();
                }
            </script>

            <form action="<?php echo FRONT_ROOT ?>Company/ShowInfo" name='getId' method='POST' class="bg-light-alpha p-5">
                <input type='hidden' name='companyId' id='id'>
                <table class="table bg-light-alpha">
                    <thead>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
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

                                    </tr>
                                <?php }
                        } else {
                                ?><tr>There is no companies</tr><?php
                                                            } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </section>
</main>