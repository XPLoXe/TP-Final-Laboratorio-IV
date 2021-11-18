<?php
    namespace Controllers;

    use DAO\CompanyDAO as CompanyDAO;
    use DAO\UserDAO as UserDAO;
    use DAO\UserRoleDAO as UserRoleDAO;
    use Models\Company as Company;
    use Models\User as User;

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

            if ($this->companyDAO->IsNameInDB($parameters['name']) || $this->companyDAO->IsEmailInDB($parameters['email']))
            {
                $message = ERROR_COMPANY_DUPLICATE ;
            }
            else
            {
                $userRoleDAO = new UserRoleDAO();
                $company = new Company();
                
                $company->setEmail($parameters['email']);
               
                $company->setPassword($this->GeneratePassword($parameters['name'], $parameters['yearOfFoundation'])); 
               

                $company->setUserRole($userRoleDAO->GetUserRoleByDescription(ROLE_COMPANY));
                $company->setActive(true);

                $company->setName($parameters['name']);
                $company->setYearOfFoundation($parameters['yearOfFoundation']);
                $company->setCity($parameters['city']);
                $company->setDescription($parameters['description']);
                $company->setLogo(base64_encode(file_get_contents($parameters['logo']["tmp_name"])));
                $company->setPhoneNumber($parameters['phoneNumber']);

                if(Utils::isAdmin())
                    $company->setApproved(true);
                else
                    $company->setApproved(false);

                $this->companyDAO->Add($company);
            }
            
            if(Utils::isAdmin())
            {
                $message = COMPANY_REGISTER_SUCCESS;
                require_once(VIEWS_PATH."home.php");
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

            $company = new Company($parameters['id']);

            $company->setName($parameters['name']);
            $company->setYearOfFoundation($parameters['yearOfFoundation']);
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


        public function GetAll($filter): array
        {
            if($filter == FILTER_ALL) 
            {
                $companyList = $this->companyDAO->GetAll(false);
                $companyList2 = $this->companyDAO->GetAll(true);
                $companyList = array_merge($companyList, $companyList2); //gets both approved and not approved
            }  

            if ($filter == FILTER_TRUE)//bool true
            {
                $companyList = $this->companyDAO->GetAll(true);//only approved
            }    
                
            if ($filter == FILTER_FALSE )//bool false
            {
                $companyList = $this->companyDAO->GetAll(false);//only not approved
            }   
                
            return $companyList;
        }


        public function ShowAddView(): void//esto no solo lo hace el admin lo hace la compania tmb
        {
            Utils::checkAdmin();

            require_once(VIEWS_PATH."company-add.php");
        }


        public function ShowListView($message = ""):void
        {
            Utils::checkUserLoggedIn();

            $companyList = $this->GetAll(FILTER_ALL);

            require_once(VIEWS_PATH."company-list.php");
        }


        public function ShowInfo(array $parameters): void
        {
            Utils::checkCompany();

            $company = $this->companyDAO->GetCompanyById((int)$parameters['id']);

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
            //filtro de no aprobadas
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
                        $this->ShowListView($message);
                    } 
                    require_once(VIEWS_PATH."company-list.php");
                }
            }
        }

        //La tengo q ver
        public function RegisterNewCompany(array $parameters): void
        {
            $this->Add($parameters);
        }


        //Esta tmb
        public function RegisterExistingCompany(array $parameters): void
        {
            Utils::checkAdmin();
            $company = $this->companyDAO->GetCompanyById($parameters['companyId']);

            mail($company->getEmail(), COMPANY_REGISTER_EMAIL_SUBJECT, COMPANY_REGISTER_EMAIL_BODY); //mail notificando
            
            $this->companyDAO->setApprovedStatus($company->getCompanyId(), true);
            $message = COMPANY_REGISTER_SUCCESS;
            
            require_once(VIEWS_PATH."home.php");
        }

        private function GeneratePassword(string $name, int $year)
        {
            $password = $name . $year;      //generated password
            $password = str_replace(' ', '', $password);
            return $password;
        }
        

        public function GetCompanyByUser(User $user): Company
        {
            return $this->companyDAO->GetCompanyByUser($user);
        }        

        public function GetCompanyById(int $companyId): Company
        {
            return $this->companyDAO->GetCompanyById($companyId);
        }
    }