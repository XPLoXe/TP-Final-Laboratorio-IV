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


        public function Add(array $parameters)
        {
            Utils::checkAdmin();

            if ($this->companyDAO->IsNameInDB($parameters['name']) || $this->companyDAO->IsEmailInDB($parameters['email']))
            {
                $message = ERROR_COMPANY_DUPLICATE ;
            }
            else
            {
                $userRoleDAO = new UserRoleDAO();
                $company = new Company();//que le pongo al constructor ?
                //$company->setUserId() va vacio al DAO
                $company->setEmail($parameters['email']);
                $company->setPassword($parameters['password']);
                $company->setUserRole($userRoleDAO->GetUserRoleByDescription(ROLE_COMPANY));
                $company->setActive(true);

                $company->setName($parameters['name']);
                $company->setYearOfFoundation($parameters['yearOfFoundation']);
                $company->setCity($parameters['city']);
                $company->setDescription($parameters['description']);
                $company->setLogo(base64_encode(file_get_contents($parameters['logo']["tmp_name"])));
                $company->setPhoneNumber($parameters['phoneNumber']);

                $this->companyDAO->Add($company);
            }

            /*if ($flag) {
               
                $companyList = $this->companyDAO->GetAll();//solo aprobadas

                require_once(VIEWS_PATH."company-list.php");
            }
            else
            {
                $message = COMPANY_REGISTERED;
                require_once(VIEWS_PATH."login.php");
            }*/

            $this->ShowListView();
            
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

            $company = new Company($parameters['id']);

            $company->setName($parameters['name']);
            $company->setYearOfFundation($parameters['yearOfFoundation']);
            $company->setCity($parameters['city']);
            $company->setDescription($parameters['description']);
            $company->setLogo($parameters['logo']['tmp_name']);
            $company->setEmail($parameters['email']);
            $company->setPassword($parameters['password']);//agregar a la vista
            $company->setPhoneNumber($parameters['phoneNumber']);
            $company->setApproved($parameters['approved']);//agregar a la vista

            $this->companyDAO->Edit($company);

            $this->ShowInfo($parameters);
        }


        public function GetAll(): array//no le veo un buen uso por ahora
        {
            $companyList = $this->companyDAO->GetAll();
            
            return $companyList;
        }


        public function ShowAddView(): void//esto no solo lo hace el admin lo hace la compania tmb
        {
            Utils::checkAdmin();

            require_once(VIEWS_PATH."company-add.php");
        }


        public function ShowListView():void
        {
            Utils::checkUserLoggedIn();

            if(Utils::isAdmin())
                $companyList = $this->companyDAO->GetAll(false);//todas
            else
                $companyList = $this->companyDAO->GetAll();//solo aprobadas

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

        //estas van a aparecer primeras en company list,no necesito un metodo
        public function ShowPendingView() //under construction
        {
            Utils::checkAdmin();
            $companyList = $this->companyDAO->GetAll(false); //it will only bring the inactive companies (those who are pending for registering)
            require_once(VIEWS_PATH."company-list.php");
        }
        
        //me faltaria verlo y editarlo para q ande con la nueva BD
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

        //La tengo q ver
        public function RegisterNewCompany(array $parameters)  
        {
            $this->Add($parameters, false);
        }

        //Esta tmb
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