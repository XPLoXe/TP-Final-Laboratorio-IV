<?php
    namespace Controllers;

    use DAO\CompanyDAO as CompanyDAO;
    use DAO\UserDAO as UserDAO;
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
            Utils::checkUserLoggedIn();

            if ($this->companyDAO->IsNameInDB($parameters['name']) || $this->companyDAO->IsEmailInDB($parameters['email']))
            {
                $message = ERROR_COMPANY_DUPLICATE ;
            }
            else
            {
                $userRoleDAO = new UserRoleDAO();
                $company = new Company();
                
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

                if(Utils::isAdmin())
                    $company->setApproved(true);
                else
                    $company->setApproved(false);

                $this->companyDAO->Add($company);
            }

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


        public function GetAll(): array
        {
            if(Utils::isAdmin())
                $companyList = $this->companyDAO->GetAll(false);//todas
            else
                $companyList = $this->companyDAO->GetAll();//solo aprobadas
            
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

            $companyList = $this->GetAll();

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
            $this->companyDAO->Delete($company->getCompanyId(), true);// setApprovedById($companyId)
            $message = COMPANY_REGISTER_SUCCESS;
            //we need to persist the new user in our data base here (using the $password generated)
            require_once(VIEWS_PATH."home.php");
            
        }

        public function GetCompanyByUser(User $user): Company
        {
            return $this->companyDAO->GetCompanyByUser($user);
        }

        
    }