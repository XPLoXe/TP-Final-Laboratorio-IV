<?php

    namespace DAO;

    use Interfaces\ICompanyDAO as ICompanyDAO;
    use Models\Company as Company;

    class CompanyDAO implements ICompanyDAO
    {
        private $companyList = array();

        public function Add(Company $company)
        {
            $this->RetrieveData();

            array_push($this->companyList, $company);

            $this->SaveData();
        }

        public function getCompanyList()
        {
            return $this->companyList;
        }
        
        public function GetAll()
        {
            $this->RetrieveData();
            
            return $this->companyList;
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

            foreach ($this->companyList as $company) {

                if ($company->getCompanyId() == $id)
                    return $company;
            }

            return null;
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

        public function editCompany($companyId, $name, $yearFoundation, $city, $description, $logo, $tmp_name, $email, $phoneNumber): bool
        {
            $this->RetrieveData();

            foreach ($this->companyList as $company) {

                if ($company->getCompanyId() == $companyId) 
                {
                    $company->setName($name);
                    $company->setYearFoundation($yearFoundation);
                    $company->setCity($city);
                    $company->setDescription($description);
                    $company->setEmail($email);
                    $company->setPhoneNumber($phoneNumber);

                    if (!empty($tmp_name));
                        $this->SaveImage($tmp_name, $logo);

                    $this->SaveData();

                    return true;
                }
            }

            return false;
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

       
        private function RetrieveData()
        {
            $this->companyList = array();

            if (file_exists('Data/companies.json')) {

                $jsonContent = file_get_contents('Data/companies.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach ($arrayToDecode as $valuesArray) {

                    $company = new Company();

                    $company->setCompanyId($valuesArray["companyId"]);
                    $company->setName($valuesArray["name"]);
                    $company->setYearFoundation($valuesArray["yearFoundation"]);
                    $company->setCity($valuesArray["city"]);
                    $company->setDescription($valuesArray["description"]);
                    $company->setLogo($valuesArray["logo"]); //check this
                    $company->setEmail($valuesArray["email"]);
                    $company->setPhoneNumber($valuesArray["phoneNumber"]);
                    $company->setActive($valuesArray["active"]);

                    array_push($this->companyList, $company);
                }
            }
        }

        public function SaveImage($tmp, $target)
        {
            move_uploaded_file($tmp, $target);
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
                $valuesArray['yearFoundation'] = $company->getYearFoundation();
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
