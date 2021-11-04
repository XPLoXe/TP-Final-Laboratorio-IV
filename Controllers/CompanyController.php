<?php
    namespace Controllers;

    use DAO\CompanyDAO as CompanyDAO;
    use Models\Company as Company;

    use Utils\Utils as Utils;

    class CompanyController
    {
        private $companyDAO;


        public function __construct()
        {
            $this->companyDAO = new CompanyDAO();
        }


        public function GetAll()
        {
            $companyList = $this->companyDAO->GetAll();
            
            return $companyList;
        }

        public function ShowAddView()
        {
            Utils::checkAdmin();

            require_once(VIEWS_PATH."company-add.php");
        }


        public function ShowListView()
        {
            Utils::checkUserLoggedIn();

            $companyList = $this->companyDAO->GetAll();

            require_once(VIEWS_PATH."company-list.php");
        }


        public function ShowEditView($parameters)
        {
            Utils::checkAdmin();

            $company = $this->companyDAO->GetCompanyById($parameters['companyId']);

            require_once(VIEWS_PATH."company-edit.php");
        }


        public function Edit($parameters)
        {
            Utils::checkAdmin();
            
            $companyId = $parameters['id'];
            $name = $parameters['name'];
            $yearOfFoundation = $parameters['yearOfFoundation'];
            $city = $parameters['city'];
            $description = $parameters['description'];           
            $logo_tmp_path = $parameters['logo']['tmp_name'];
            $email = $parameters['email'];
            $phoneNumber = $parameters['phoneNumber'];

            $this->companyDAO->Edit($companyId, $name, $yearOfFoundation, $city, $description, $logo_tmp_path, $email, $phoneNumber);

            $this->ShowInfo($parameters);
        }


        public function Delete($parameters)
        {
            Utils::checkAdmin();

            $this->companyDAO->Delete($parameters['companyId']);

            $this->ShowListView();
        }


        public function Add($parameters)
        {
            Utils::checkAdmin();

            $company = new Company();
            $company->setName($parameters['name']);
            $company->setYearOfFoundation($parameters['yearOfFoundation']);
            $company->setCity($parameters['city']);
            $company->setDescription($parameters['description']);
            $company->setLogo(base64_encode(file_get_contents($parameters['logo']["tmp_name"])));
            $company->setEmail($parameters['email']);
            $company->setPhoneNumber($parameters['phoneNumber']);
            $company->setActive(true);

            $this->companyDAO->Add($company);

            $this->ShowListView();
        }
        

        public function FilterByName($parameters)
        {
            Utils::checkUserLoggedIn();

            if ($_SERVER['REQUEST_METHOD'] == "POST") { 

                if (empty($parameters["nameToFilter"])) 
                {
                    $this->ShowListView();
                } else
                {
                    $companyList  = $this->companyDAO->GetCompaniesFilteredByName($parameters["nameToFilter"]);

                    if (empty($companyList))
                    {
                        $msgErrorFilter = '<strong style="color:red; font-size:small;"> Ninguna Compañia contiene el nombre ingresado </strong>'; // TODO: move HTML code to view

                        $companyList = $this->companyDAO->GetAll();
                    } 

                    require_once(VIEWS_PATH."company-list.php");

                }
            }
        }


        public function ShowInfo($parameters)
        {
            Utils::checkUserLoggedIn();

            $company = $this->companyDAO->GetCompanyById($parameters['id']);

            require_once(VIEWS_PATH."company-info.php");
        }
    }