<?php
    namespace Controllers;

    use DAO\CompanyDAO as CompanyDAO;
    use Models\Company as Company;

    class CompanyController
    {
        private $companyDAO;

        public function __construct()
        {
            $this->companyDAO = new CompanyDAO();
        }

        public function ShowAddView()
        {
            require_once(VIEWS_PATH."company-add.php");
        }

        public function ShowListView()
        {
            $companyList = $this->companyDAO->GetAll(true);

            require_once(VIEWS_PATH."company-list.php");
        }

        public function ShowAlterView($parameters)
        {
            $company = $this->companyDAO->getCompanyById($parameters['companyId']);
            require_once(VIEWS_PATH."company-alter.php");
        }

        public function Alter($idCompanyToAlter, $name, $yearFoundation, $city, $description, $logo, $email, $phoneNumber, $active)
        {
           $parameters = array();

            if ($_SERVER['REQUEST_METHOD'] == "POST") { 

                $parameters = $_POST;

                $idCompanyToAlter = $_POST["companyId"];
                $name = $_POST["name"];
                $yearFoundation = $_POST["yearFoundation"];
                $city = $_POST["city"];
                $description = $_POST["description"];
                $logo = $_POST["logo"];
                $email = $_POST["email"]; 
                $phoneNumber = $_POST["phoneNumber"];
                $active = $_POST["active"];


                $this->companyDAO->alterCompany($idCompanyToAlter, $name, $yearFoundation, $city, $description, $logo, $email, $phoneNumber, $active);

            }

            require_once(VIEWS_PATH."company-info.php");

        }

        public function Delete($parameters)
        { 
            $this->companyDAO->deleteCompany($parameters['delete']);

            $this->ShowListView();

        }

        public function Add($parameters)
        {
            $tmp = ($parameters['logo']['tmp_name']);
            $target = IMG_PATH.$parameters['logo']['name'];
            #die(var_dump($_FILES));
            $company = new Company();
            $company->setName($parameters['name']);
            $company->setYearFoundation($parameters['yearFoundation']);
            $company->setCity($parameters['city']);
            $company->setDescription($parameters['description']);
            $company->setLogo($parameters['logo']['name']);
            $company->setEmail($parameters['email']);
            $company->setPhoneNumber($parameters['phoneNumber']);
            $company->setActive(true);

            $this->companyDAO->Add($company);
            $this->companyDAO->SaveImage($tmp, $target);

            $this->ShowListView();
        }
        
        public function FilterByName($parameters){

            if ($_SERVER['REQUEST_METHOD'] == "POST") { 

                if(empty($parameters["nameToFilter"])){//Si ingreso el input vacio apareceran todas las companias

                    $this->ShowListView();

                }else{

                    $aCompanyWasFiltered  = $this->companyDAO->getCompaniesFilterByName($parameters["nameToFilter"]);//This modificate the $companyList if there is any filter ocasion

                    if($aCompanyWasFiltered===false){

                        $msgErrorFilter = '<strong style="color:red; font-size:small ;"> Ninguna Compañia contiene el nombre ingresado </strong>';

                        $companyList = $this->companyDAO->GetAll(); //No llamo al metodo ShowListView porq no me aparecera el msg

                        require_once(VIEWS_PATH."company-list.php");
    
                    }else{

                        $companyList = $this->companyDAO->getCompanyList();

                        require_once(VIEWS_PATH."company-list.php");

                    }

                    

                }

            }

        }

        public function ShowInfo($parameters)
        {
            $company = $this->companyDAO->getCompanyById($parameters['id']);
            require_once(VIEWS_PATH."company-info.php");
        }
    }
