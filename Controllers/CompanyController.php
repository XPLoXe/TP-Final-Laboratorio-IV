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
            $companyList = $this->companyDAO->GetAll();

            require_once(VIEWS_PATH."company-list.php");
        }

        public function Add($name, $yearFoundation, $city, $description, $logo, $email, $phoneNumber)
        {
            $parameters=array();

            if ($_SERVER['REQUEST_METHOD'] == "POST") { 

                $parameters = $_POST;
                $name = $_POST["name"];
                $yearFoundation = $_POST["yearFoundation"];
                $city = $_POST["city"];
                $description = $_POST["description"];
                $logo = $_POST["logo"];
                $email = $_POST["email"];
                $phoneNumber = $_POST["phoneNumber"];

                $company = new Company();
                
                //The ID is set in SaveData in CompanyDAO

                $company->setName($name);
                $company->setYearFoundation($yearFoundation);
                $company->setCity($city);
                $company->setDescription($description);
                $company->setLogo($logo);
                $company->setEmail($email);
                $company->setPhoneNumber($phoneNumber);
                $company->setActive(true);

                $this->companyDAO->Add($company);

                $this->ShowListView();

            }//Poner un else de q pasa si no es post
        }

        public function Alter($idCompanyToAlter, $name, $yearFoundation, $city, $description, $logo, $email, $phoneNumber, $active){

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

        public function Delete(Company $companyToDelete){ //When we delete a company we put the active atribute in false   
         
            if ($_SERVER['REQUEST_METHOD'] == "POST") { 

                $parameters = $_POST;

                $companyToDelete = $_POST["companyInfo"];

                $this->companyDAO->deleteCompany($companyToDelete);
            }

                $this->ShowListView();

        }

        public function FilterByName($name){

            $parameters = array();

            if ($_SERVER['REQUEST_METHOD'] == "POST") { //Maybe this is GET

                $parameters = $_POST;

                $name = $_POST["nameToFilter"];

                $aCompanyWasFiltered  = $this->companyDAO->getCompaniesFilterByName($name);//This modificate the $companyList if there is any filter ocasion

                if(!$aCompanyWasFiltered){

                    $msgErrorFilter = '<strong style="color:red; font-size:large;">None of the Companies contains the input</strong>';

                    $this->ShowListView();

                }else{

                    require_once(VIEWS_PATH."company-list.php");

                }

            }

        }

        public function ShowInfo($companyId){

            $parameters = array();

            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                $parameters = $_POST;

                $companyInfo = $this->companyDAO->getCompanyById($_POST["companyId"]);

                require_once(VIEWS_PATH."company-info.php");

                //Seria imposible q no exista el id de la compania pasado por parametro

            }

        }
    }
?>