<?php

    namespace DAO;

    use Exception;  
    use Models\Company as Company;

    class CompanyDAO
    {
        private $companyList = array();
        private $tableName = "Companies";

        public function Add(Company $company)
        {
            try
            {
                if(!$this->isCompanyInBD($parameters["name"], $parameters["email"])){

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
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function isCompanyInBD($name,$email){

            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE name='".$companyName."' AND email='".$email."'";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
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


        public function GetAll()
        {
            try
            {
                $companyList = array();

                $query =   "SELECT * FROM ".$this->tableName.";";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {
                    if ($row["active"] == 1)
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
                }

                return $companyList;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function getCompanyByEmail($email)
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE email='".$email."'";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                return $resultSet;
                    
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        public function getCompanyById($id)
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE company_id='".$id."'";

                $this->connection = Connection::GetInstance();

                $row = $this->connection->Execute($query)[0];

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

        public function getCompanyIdByName(string $name): int
        {
            try
            {    
                $query = "SELECT company_id FROM ".$this->tableName." WHERE name='.$name.'";
    
                $this->connection = Connection::GetInstance();
    
                $companyId = $this->connection->Execute($query)[0]['company_id'];
    
                return $companyId;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function isNameinCompanyName($companyName,$name)
        {
            if (stripos($companyName,$name) === false)
                return false;
            else
                return true;
        }

        public function getCompaniesFilterByName($name)
        {
            try
            {    
                $query = "SELECT * FROM ".$this->tableName." WHERE name LIKE '%$name%'";
    
                $this->connection = Connection::GetInstance();
    
                $filterCompanies = $this->connection->Execute($query);

                $companyList = array();

                if(!empty($filterCompanies)){

                    foreach ($filterCompanies as $row)
                    {
                        if ($row["active"] == 1)
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
                }

                return $companyList;
    
            }
            catch (Exception $ex)
            {
                throw $ex;
            }

        }


        public function deleteCompany($id)
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET active='false' WHERE company_id='".$id."'";

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query);
                
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function editCompany($companyId, $name, $yearFoundation, $city, $description, $logo, $tmp_name, $email, $phoneNumber)
        {
            try
            {
                $query = "UPDATE ".$this->tableName." 
                        SET name='".$name."', year_of_foundation='".$yearFoundation."', 
                            city= '".$city."', description='".$description."',
                            logo='".$logo."', email='".$email."', phone_number='".$phoneNumber."'
                            WHERE company_id='".$companyId."'";

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query);
                
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function SaveCompanyLogo($tmp_img_path)//Editar
        {
            try
            {
                if (!is_dir($target_path))
                {
                    mkdir($target_path);
                }
                $logo_name = 'logo.'.$image_ext;
                move_uploaded_file($tmp_img_path, $target_path.$logo_name);

                //save logo to db
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }
  
    }