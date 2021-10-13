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

        public function getCompaniesFilterByName($name)
        {
            $this->RetrieveData();

            $filterCompanies = array();

            foreach ($this->companyList as $company) {

                if (array_search($name, $company->getName()) && $company->isActive())
                    array_push($filterCompanies, $company);
            }

            if (!empty($filterCompanies)) {
                $this->companyList = $filterCompanies;
                $this->companyList = $filterCompanies;
                $this->companyList = $filterCompanies;
                $this->companyList = $filterCompanies;
                $this->companyList = $filterCompanies;

                return true;
                /*Si tiene algun dato el arreglo con las companias filtradas, quiere decir q tuvimos exito al encontrar companias
                    que contengan el string ingresado por usuario
                    Me da un toque de miedo modificar el $this->companyList pero todavia no veo un escenario donde pierda datos*/
            }

            return false;
            /*Si ingresamos un 1 en el input, y no hay ninguna empresa q contenga un 1 como nombre, nos arrojara un false
                y con este return podemos mostrar un mensaje diciendo q ninguna compania contiene el string ingresado*/
        }

        public function deleteCompany($companyToDelete)
        { // return a boolean

            $this->RetrieveData();

            foreach ($this->companyList as $company) {

                if ($company->getCompanyId() == $companyToDelete->getCompanyId()) {

                    $companyToDelete->setActive(false);

                    $this->SaveData();

                    return true; //With this i can stop to iterate and we can check that the company was altered

                }
            }

            return false;
        }

        public function alterCompany($idCompanyToAlter, $name, $yearFoundation, $city, $description, $email, $phoneNumber, $active)
        { // return a boolean

            $this->RetrieveData();

            foreach ($this->companyList as $company) {

                if ($company->getCompanyId() == $idCompanyToAlter) {

                    if (!empty($name))
                        $company->setName($name);

                    if (!empty($yearFoundation))
                        $company->setYearFoundation($yearFoundation);

                    if (!empty($city))
                        $company->setCity($city);

                    if (!empty($description))
                        $company->setDescription($description);

                    if (!empty($logo))
                        $company->setLogo($logo);

                    if (!empty($email))
                        $company->setEmail($email);

                    if (!empty($phoneNumber))
                        $company->setPhoneNumber($phoneNumber);

                    if (!empty($active))
                        $company->setActive($active);


                    $this->SaveData(); //i hope not have problems with the Id 
                    $this->SaveData(); //i hope not have problems with the Id 
                    $this->SaveData(); //i hope not have problems with the Id 
                    $this->SaveData(); //i hope not have problems with the Id 
                    $this->SaveData(); //i hope not have problems with the Id 

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

        public function getNewCompanyId($company){

            return array_search($company,$this->companyList);

        }

        private function SaveData()
        {
            $arrayToEncode = array();

            foreach ($this->companyList as $company) {

                $valuesArray["companyId"] = $this->getNewCompanyId($company);
                $valuesArray["name"] = $company->getName();
                $valuesArray["yearFoundation"] = $company->getYearFoundation();
                $valuesArray["city"] = $company->getCity();
                $valuesArray["description"] = $company->getDescription();
                $valuesArray["logo"] = $company->getLogo(); //Check this, because we use a picture
                $valuesArray["email"] = $company->getEmail();
                $valuesArray["phoneNumber"] = $company->getPhoneNumber();
                $valuesArray["active"] = $company->isActive();


                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents(JSON_PATH . 'companies.json', $jsonContent);
        }
    }
