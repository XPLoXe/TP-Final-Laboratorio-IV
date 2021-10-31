<?php
    namespace Controllers;

    use DAO\JobOfferDAO as JobOfferDAO;
    use Models\JobOffer as JobOffer;

    use Utils\Utils as Utils;

    class JobOfferController
    {
        private $jobOfferDAO;

        public function __construct()
        {
            $this->$jobOfferDAO = new JobOfferDAO();
        }

        public function ShowAddView()
        {
            Utils::checkAdmin();

            require_once(VIEWS_PATH."joboffer-add.php");
        }

        public function ShowListView()
        {
            Utils::checkUserLoggedIn();

            //Debo actualizar la base de datos con la api
            //JobPosition
            //Career
            //CareerJobPosition
            //y con esto actualizado, actualizar tmb la base de datos de las JobOffer

            if(Utils::isAdmin()){
                $jobOfferList = $this->jobOfferDAO->GetAll();
            }

            if(Utils::isUserLoggedIn()){//modificar el jobOfferList para q aparezcan los de su carrera 

                $studentController = new StudentController();

                $careerId = $studentController->getCareerIdByStudentId($_SESSION['loggedUser']['api_user_id']);

                $jobOfferList = $this->jobOfferDAO->getJobOfferByCareerId($careerId);//no va xq joboffer no tiene careerId
            }


        
            //necesito ir a la controladora de JobPosition y Company para q me tire los datos necesarios de la $jobOfferList

            require_once(VIEWS_PATH."joboffer-list.php");
        }


        public function ShowEditView($parameters)
        {
            Utils::checkAdmin();
            
            $company = $this->companyDAO->getCompanyById($parameters['edit']);

            require_once(VIEWS_PATH."company-edit.php");
        }


        public function Edit($parameters)
        {
            Utils::checkAdmin();
            
            $companyId = $parameters['id'];
            $name = $parameters['name'];
            $yearFoundation = $parameters['yearFoundation'];
            $city = $parameters['city'];
            $description = $parameters['description'];           
            $logo = $parameters['logo']['name'];
            $tmp_name = $parameters['logo']['tmp_name'];
            $email = $parameters['email'];
            $phoneNumber = $parameters['phoneNumber'];

            $this->companyDAO->editCompany($companyId, $name, $yearFoundation, $city, $description, $logo, $tmp_name, $email, $phoneNumber);

            $this->ShowInfo($parameters);
        }


        public function Delete($parameters)
        {
            Utils::checkAdmin();

            $this->companyDAO->deleteCompany($parameters['delete']);

            $this->ShowListView();
        }


        public function Add($parameters)
        {
            Utils::checkAdmin();

            $tmp = ($parameters['logo']['tmp_name']);
            $target = $parameters['logo']['name'];

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
        

        public function FilterByName($parameters)
        {
            Utils::checkUserLoggedIn();

            if ($_SERVER['REQUEST_METHOD'] == "POST") { 

                if (empty($parameters["nameToFilter"])) 
                { //Si ingreso el input vacio apareceran todas las companias

                    $this->ShowListView();

                } else
                {
                    $aCompanyWasFiltered  = $this->companyDAO->getCompaniesFilterByName($parameters["nameToFilter"]);//This modificate the $companyList if there is any filter ocasion

                    if ($aCompanyWasFiltered == false)
                    {
                        $msgErrorFilter = '<strong style="color:red; font-size:small; text-align: center;"> Ninguna Compañia contiene el nombre ingresado </strong>';

                        $companyList = $this->companyDAO->GetAll(); //No llamo al metodo ShowListView porq no me aparecera el msg

                        require_once(VIEWS_PATH."company-list.php");

                    } else
                    {
                        $companyList = $this->companyDAO->getCompanyList();

                        require_once(VIEWS_PATH."company-list.php");
                    }
                }
            }
        }


        public function ShowInfo($parameters)
        {
            Utils::checkUserLoggedIn();

            $company = $this->companyDAO->getCompanyById($parameters['id']);
            require_once(VIEWS_PATH."company-info.php");
        }
    }
