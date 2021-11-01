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


        public function checkIfCompanyExists($companyName){

            $this->RetrieveData();

            foreach($this->companyList as $company){

                if( strcasecmp ($company->getName(), $companyName ) === 0 )
                    return false;
            }

            return true;
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
            $this->RetrieveData();

            foreach ($this->companyList as $$company) {

                if ($email == $company->getEmail()) {
                    return $company;
                }
            }

            return null;
        }


        public function getCompanyById($id)
        {
            $this->RetrieveData();

            foreach ($this->companyList as $company) 
            {
                if ($company->getCompanyId() == $id)
                    return $company;
            }

            return null;
        }

        public function getCompanyIdByName(string $name): int
        {
            try
            {    
                $query = "SELECT company_id FROM ".$this->tableName.' WHERE name="'.$name.'"';
    
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
            $this->RetrieveData();

            $filterCompanies = array();

            foreach ($this->companyList as $company)
            {
                if ( $this->isNameinCompanyName($company->getName(),$name) && $company->isActive() )
                    array_push($filterCompanies, $company);
            }

            if (!empty($filterCompanies)) 
            {
                $this->companyList = $filterCompanies;

                return true;

            } else

                return false;
        }


        public function deleteCompany($id)
        {
            $this->RetrieveData();

            $company = $this->getCompanyById($id);
            $company->setActive(false);

            $this->SaveData();
        }


        public function editCompany($companyId, $name, $yearFoundation, $city, $description, $logo, $tmp_name, $email, $phoneNumber): Company
        {
            $this->RetrieveData();

            foreach ($this->companyList as $company) {

                if ($company->getCompanyId() == $companyId) 
                {
                    $company->setName($name);
                    $company->setYearOfFoundation($yearFoundation);
                    $company->setCity($city);
                    $company->setDescription($description);
                    $company->setEmail($email);
                    $company->setPhoneNumber($phoneNumber);

                    if (!empty($tmp_name))
                    {
                        $this->SaveImage($tmp_name, $logo);
                        $company->setLogo($logo);
                    }
                    $this->SaveData();

                    return $company;
                }
            }

            return null;
        }


        public function getActiveCompanies()
        {
            $this->RetrieveData();

            $activeCompanies = array();

            foreach ($this->companyList as $company) {

                if ($company->isActive()) {
                    array_push($activeCompanies, $company);
                }
            }

            return $activeCompanies;
        }


        public function SaveCompanyLogo($tmp_img_path)
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


        public function getCompanyPositionInArray($company)
        {
            return array_search($company,$this->companyList); //TODO: Rewrite this to avoid edge case where a company is deleted
        }                                                     // and every id is now offset from array index


        private function SaveData()
        {
            $arrayToEncode = array();

            foreach ($this->companyList as $company) {

                $valuesArray['companyId'] = $this->getCompanyPositionInArray($company);
                $valuesArray['name'] = $company->getName();
                $valuesArray['yearFoundation'] = $company->getYearOfFoundation();
                $valuesArray['city'] = $company->getCity();
                $valuesArray['description'] = $company->getDescription();
                $valuesArray['logo'] = $company->getLogo();
                $valuesArray['email'] = $company->getEmail();
                $valuesArray['phoneNumber'] = $company->getPhoneNumber();
                $valuesArray['active'] = $company->isActive();

                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents(JSON_PATH . 'companies.json', $jsonContent);
        }    
    }