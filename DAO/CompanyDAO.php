<?php

    namespace DAO;

    use Models\Company as Company;
    use Models\User as User;
    use DAO\UserDAO as UserDAO;
    use Exception;

    class CompanyDAO
    {
        private $tableName = "Companies";
        private $userDAO;

        public function __construct()
        {
            $this->userDAO = new UserDAO();
        }


        public function Add(Company $company)
        {
            try
            {
                $query = "INSERT INTO ".$this->tableName." (user_company_id, name, year_of_foundation, city, description, logo, phone_number, approved) VALUES (:user_company_id, :name, :year_of_foundation, :city, :description, :logo, :phone_number, :approved);";

                
                $this->userDAO->Add($company->getUser());
                
                $parameters["user_company_id"] = (string)$this->userDAO->GetLastId();
                
                $parameters["name"] = $company->getName();
                $parameters["year_of_foundation"] = $company->getYearOfFoundation();
                $parameters["city"] = $company->getCity();
                $parameters["description"] = $company->getDescription();
                $parameters["logo"] = $company->getLogo();
                $parameters["phone_number"] = $company->getPhoneNumber();
                $parameters["approved"] = $company->isApproved();
                
                $this->connection = Connection::GetInstance();
    
                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function Delete(int $companyId): void
        {
            try
            {
                $this->userDAO->Delete($companyId);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function Edit($company)
        {
            try
            {
                if ($company->getLogo() !== '')
                {
                    $logo = 'logo = :logo,';
                    $parameters['logo'] = base64_encode(file_get_contents($company->getLogo()));
                } else
                    $logo = ' ';

                $this->userDAO->Edit($company->getUser());

                $query = "UPDATE ".$this->tableName.' 
                          SET name = :name, year_of_foundation = :year_of_foundation, city = :city, description = :description,'. $logo .', phone_number = :phone_number, approved = :approved WHERE company_id = :company_id;';

                $parameters['company_id'] = $company->getUserId();//Hace falta el companyId del modelo Company ?
                $parameters['name'] = $name;
                $parameters['year_of_foundation'] = $yearOfFoundation;
                $parameters['city'] = $city;
                $parameters['description'] = $description;
                $parameters['phone_number'] = $phoneNumber;
                $parameters['approved'] = $approved;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function IsNameInDB(string $name): bool
        {
            try
            {
                $query = "SELECT name FROM ".$this->tableName." WHERE name = :name ;";

                $parameters['name'] = $name;
 
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query,$parameters);
                
                if (!empty($resultSet))
                    return true;
                else
                    return false;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function IsEmailInDB(string $email): bool
        {
            try
            {
                return $this->userDAO->IsEmailInDB($email);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function GetAll( $onlyApproved = true ): array
        {
            try
            {
                $userCompanyList = $this->userDAO->GetAll(ROLE_COMPANY);

                $companyList = array();

                if($onlyApproved == true)
                    $parameters['approved'] = 1;
                else
                    $parameters['approved'] = 0;


                $query = 'SELECT * FROM '.$this->tableName.'  WHERE approved = :approved ORDER BY user_company_id ;';


                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);
                
                foreach ($resultSet as $row)
                {
                    $user = $this->userDAO->GetSpecificUser($userCompanyList,$row["user_company_id"]);

                    $company = new Company($user->getUserId());

                    $company->setEmail($user->getEmail());
                    $company->setPassword($user->getPassword());
                    $company->setUserRole($user->getUserRole());
                    //$company->setActive($user->getActive());
                    
                    $company->setName($row["name"]);
                    $company->setYearOfFoundation($row["year_of_foundation"]);
                    $company->setCity($row["city"]);
                    $company->setDescription($row["description"]);
                    $company->setLogo($row["logo"]);
                    $company->setPhoneNumber($row["phone_number"]);
                    $company->setApproved((bool)$row["approved"]);

                    array_push($companyList,$company);
                }
                
                return $companyList;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        
        public function GetCompanyById(int $companyId): Company
        {
            try
            {
                $userCompany = $this->userDAO->GetUserById($companyId);

                $query = "SELECT * FROM ".$this->tableName." WHERE user_company_id = :company_id;";

                $parameters['company_id'] = $companyId;

                $this->connection = Connection::GetInstance();

                $row = $this->connection->Execute($query, $parameters)[0];

                $company = new Company($row["user_company_id"]);
                $company->setName($row["name"]);
                $company->setYearOfFoundation($row["year_of_foundation"]);
                $company->setCity($row["city"]);
                $company->setDescription($row["description"]);
                $company->setLogo($row["logo"]);
                $company->setPhoneNumber($row["phone_number"]);
                $company->setApproved($row['approved']);

                $company->setEmail($userCompany->getEmail());
                $company->setPassword($userCompany->getPassword());
                $company->setUserRole($userCompany->getUserRole());
                $company->setActive($userCompany->isActive());
               
                return $company;  
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function GetCompaniesFilteredByName(string $name): array
        {
            try
            {    
                $query = "SELECT * FROM ".$this->tableName." WHERE name LIKE '%$name%' AND active = :active;";

                $parameters['active'] = true;
                
                $this->connection = Connection::GetInstance();
    
                $filteredCompanies = $this->connection->Execute($query, $parameters);

                $companyList = array();

                if (!empty($filteredCompanies))
                {
                    foreach ($filteredCompanies as $row)
                    {
                        $userCompany = $this->userDAO->GetUserById($companyId);

                        $company = new Company($row["company_id"]);
                        $company->setName($row["name"]);
                        $company->setYearOfFoundation($row["year_of_foundation"]);
                        $company->setCity($row["city"]);
                        $company->setDescription($row["description"]);
                        $company->setLogo($row["logo"]);
                        $company->setPhoneNumber($row["phone_number"]);
                        $company->setApproved($row['approved']);

                        $company->setEmail($userCompany->getEmail());
                        $company->setPassword($userCompany->getPassword());
                        $company->setUserRole($userCompany->getUserRole());
                        $company->setActive($userCompany->isActive());

                        array_push($companyList,$company);
                    }
                }
                return $companyList;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        public function GetCompanyByUser($user): Company
        {
            try
            {
                $userCompany= $this->userDAO->GetUserById($user->getUserId());

                $query = 'SELECT * FROM '.$this->tableName.' WHERE user_company_id = :user_company_id;';

                $parameters['user_company_id'] = $userCompany->getUserId();

                $this->connection = Connection::GetInstance();

                $row = $this->connection->Execute($query, $parameters)[0];
                
                if (!empty($row))
                {
                    $company = new Company();

                    $company->setCompanyId($userCompany->getUserId());
                    $company->setEmail($userCompany->getEmail());
                    $company->setPassword($userCompany->getPassword());
                    $company->setUserRole($userCompany->getUserRole());
                    $company->setActive($userCompany->isActive());

                    $company->setName($row["name"]);
                    $company->setYearOfFoundation($row["year_of_foundation"]);
                    $company->setCity($row["city"]);
                    $company->setDescription($row["description"]);
                    $company->setLogo($row["logo"]);
                    $company->setPhoneNumber($row["phone_number"]);
                    $company->setApproved($row["approved"]);                    
                }
                
                return $company;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }

        }

        public function setApprovedStatus(int $companyId, bool $flag): void
        {
            
            try
            {
                $query =   "UPDATE ".$this->tableName." SET approved = :approved WHERE user_company_id = :user_company_id ;";

                $parameters['user_company_id'] = $companyId;

                if ($flag) 
                {
                    $parameters['approved'] = 1;
                }
                else
                {
                    $parameters['approved'] = 0;    
                }
                
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }

        }
    }