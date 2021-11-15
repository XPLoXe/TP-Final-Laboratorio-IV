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


        public function Add(array $parameters, bool $flag = true)
        {
            Utils::checkAdmin();

            if ($this->companyDAO->IsNameInBD($parameters['name']) || $this->companyDAO->IsEmailInBD($parameters['email']))
            {
                $message = ERROR_COMPANY_DUPLICATE ;
            }
            else
            {
                $company = new Company();
                $company->setName($parameters['name']);
                $company->setYearOfFoundation($parameters['yearOfFoundation']);
                $company->setCity($parameters['city']);
                $company->setDescription($parameters['description']);
                $company->setLogo(base64_encode(file_get_contents($parameters['logo']["tmp_name"])));
                $company->setEmail($parameters['email']);
                $company->setPhoneNumber($parameters['phoneNumber']);

                if ($flag) {
                    $company->setActive(true);
                }
                else
                {
                    $company->setActive(false);
                }
               

                $this->companyDAO->Add($company);
            }

            if ($flag) {
                $companyList = $this->companyDAO->GetAll();

                require_once(VIEWS_PATH."company-list.php");
            }
            else
            {
                $message = COMPANY_REGISTERED;
                require_once(VIEWS_PATH."login.php");
            }
            
        }


        public function Delete(array $parameters)
        {
            Utils::checkAdmin();

            $this->companyDAO->Delete($parameters['companyId']);

            $this->ShowListView();
        }


        public function Edit(array $parameters)
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


        public function GetAll(): array
        {
            $companyList = $this->companyDAO->GetAll();
            
            return $companyList;
        }


        public function ShowAddView(): void
        {
            Utils::checkAdmin();

            require_once(VIEWS_PATH."company-add.php");
        }


        public function ShowListView():void
        {
            Utils::checkUserLoggedIn();

            $companyList = $this->companyDAO->GetAll();

            require_once(VIEWS_PATH."company-list.php");
        }


        public function ShowInfo(array $parameters): void
        {
            Utils::checkUserLoggedIn();

            $company = $this->companyDAO->GetCompanyById($parameters['id']);

            require_once(VIEWS_PATH."company-info.php");
        }


        public function ShowEditView(array $parameters): void
        {
            Utils::checkAdmin();

            $company = $this->companyDAO->GetCompanyById($parameters['companyId']);

            require_once(VIEWS_PATH."company-edit.php");
        }

        public function ShowPendingView() //under construction
        {
            Utils::checkAdmin();
            $companyList = $this->companyDAO->GetAll(false); //it will only bring the inactive companies (those who are pending for registering)
            require_once(VIEWS_PATH."company-list.php");
        }
        

        public function FilterByName(array $parameters): void
        {
            Utils::checkUserLoggedIn();

            if ($_SERVER['REQUEST_METHOD'] == "POST") { 

                if (empty($parameters["nameToFilter"]))
                {
                    $this->ShowListView();
                }
                else
                {
                    $companyList  = $this->companyDAO->GetCompaniesFilteredByName($parameters["nameToFilter"]);

                    if (empty($companyList))
                    {
                        $message = ERROR_COMPANY_FILTER;
                        $companyList = $this->companyDAO->GetAll();
                    } 
                    require_once(VIEWS_PATH."company-list.php");
                }
            }
        }

        public function RegisterNewCompany(array $parameters)  
        {
            $this->Add($parameters, false);
        }

        public function RegisterExistingCompany(array $parameters)
        {
            Utils::checkAdmin();
            $company = $this->companyDAO->GetCompanyById($parameters['companyId']);
            $password = $company->getName() . $company->getYearOfFoundation();      //generated password
            $password = str_replace(' ', '', $password);
            
            mail($company->getEmail(), COMPANY_REGISTER_EMAIL_SUBJECT, COMPANY_REGISTER_EMAIL_BODY); //mail notificando
            $this->companyDAO->Delete($company->getCompanyId(), true);
            $message = COMPANY_REGISTER_SUCCESS;
            //we need to persist the new user in our data base here (using the $password generated)
            require_once(VIEWS_PATH."home.php");
            
        }

        
    }