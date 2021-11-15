<?php

    namespace DAO;

    use Models\Company as Company;
    use Exception;

    class CompanyDAO
    {
        private $companyList = array();
        private $tableName = "Companies";


        public function Add(Company $company)
        {
            try
            {
                $query = "INSERT INTO ".$this->tableName." (name, year_of_foundation, city, description, logo, email, phone_number) VALUES (:name, :year_of_foundation, :city, :description, :logo, :email, :phone_number);";

                $parameters["name"] = $company->getName();
                $parameters["year_of_foundation"] = $company->getYearOfFoundation();
                $parameters["city"] = $company->getCity();
                $parameters["description"] = $company->getDescription();
                $parameters["logo"] = $company->getLogo();
                $parameters["email"] = $company->getEmail();
                $parameters["phone_number"] = $company->getPhoneNumber();
                
                $this->connection = Connection::GetInstance();
    
                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function Delete(int $companyId, bool $flag = false): void
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET active = :active WHERE company_id = :company_id;";

                $parameters['company_id'] = $companyId;
                if ($flag)
                {
                    $parameters['active'] = 1;
                }
                else
                {
                    $parameters['active'] = 0;
                }

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function Edit(int $companyId, string $name, string $yearOfFoundation, string $city, string $description, string $logo_tmp_path, string $email, string $phoneNumber)
        {
            try
            {
                if ($logo_tmp_path !== '')
                {
                    $logo = 'logo = :logo,';
                    $parameters['logo'] = base64_encode(file_get_contents($logo_tmp_path));
                } else
                    $logo = ' ';

                $query = "UPDATE ".$this->tableName.' 
                          SET name = :name, year_of_foundation = :year_of_foundation, city = :city, description = :description,'. $logo .'email = :email, phone_number = :phone_number WHERE company_id = :company_id;';

                $parameters['company_id'] = $companyId;
                $parameters['name'] = $name;
                $parameters['year_of_foundation'] = $yearOfFoundation;
                $parameters['city'] = $city;
                $parameters['description'] = $description;
                $parameters['email'] = $email;
                $parameters['phone_number'] = $phoneNumber;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function IsNameInBD(string $name): bool
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


        public function IsEmailInBD(string $email): bool
        {
            try
            {
                $query = "SELECT email FROM ".$this->tableName." WHERE email = :email ;";

                $parameters['email'] = $email;
 
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query,$parameters);
                
                if(!empty($resultSet))
                    return true;
                else
                    return false;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function GetAll(bool $flag = true): array
        {
            try
            {
                $companyList = array();

                $query = 'SELECT * FROM '.$this->tableName.' WHERE active = :active;';
                
                if ($flag) {
                   $parameters['active'] = true;
                }
                else
                {
                    $parameters['active'] = false;
                }
                
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);
                
                foreach ($resultSet as $row)
                {
                    $company = new Company($row["company_id"]);

                    $company->setName($row["name"]);
                    $company->setYearOfFoundation($row["year_of_foundation"]);
                    $company->setCity($row["city"]);
                    $company->setDescription($row["description"]);
                    $company->setLogo($row["logo"]);
                    $company->setEmail($row["email"]);
                    $company->setPhoneNumber($row["phone_number"]);
                    $company->setActive($row["active"]);

                    $companyList[$company->getCompanyId()] = $company;
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
                $query = "SELECT * FROM ".$this->tableName." WHERE company_id = :company_id;";

                $parameters['company_id'] = $companyId;

                $this->connection = Connection::GetInstance();

                $row = $this->connection->Execute($query, $parameters)[0];

                $company = new Company($row["company_id"]);
                $company->setName($row["name"]);
                $company->setYearOfFoundation($row["year_of_foundation"]);
                $company->setCity($row["city"]);
                $company->setDescription($row["description"]);
                $company->setLogo($row["logo"]);
                $company->setEmail($row["email"]);
                $company->setPhoneNumber($row["phone_number"]);
                $company->setActive($row["active"]);
               
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
                // Can't use binded parameters because of the framework
                $parameters['active'] = true;
                
                $this->connection = Connection::GetInstance();
    
                $filteredCompanies = $this->connection->Execute($query, $parameters);

                $companyList = array();

                if (!empty($filteredCompanies))
                {
                    foreach ($filteredCompanies as $row)
                    {
                        $company = new Company($row["company_id"]);

                        $company->setName($row["name"]);
                        $company->setYearOfFoundation($row["year_of_foundation"]);
                        $company->setCity($row["city"]);
                        $company->setDescription($row["description"]);
                        $company->setLogo($row["logo"]);
                        $company->setEmail($row["email"]);
                        $company->setPhoneNumber($row["phone_number"]);
                        $company->setActive($row["active"]);

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
    }