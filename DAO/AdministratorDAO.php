<?php
namespace DAO;

use Interfaces\IAdministratorDAO as IAdministratorDAO;

class AdministratorDAO implements IAdministratorDAO
{
    private $administratorList = array();

    public function Add(Administrator $administrator){

        $this->RetrieveData();
            
        array_push($this->administratorList, $administrator);

        $this->SaveData();

    }

    public function GetAll()
    {
        $this->RetrieveData();

        return $this->$administratorList;
    }

    public function getAdministratorByEmail($email)
    {

        $this->RetrieveData();

        foreach ($this->$administratorList as $administrator) {

            if ($email == $administrator->getEmail()) {
                return $administrator;
            }

        }

        return null;
    }

    public function getActiveAdministrators()
    {

        $this->RetrieveData();

        $activeAdministrators = array();

        foreach ($this->$administratorList as $administrator) {

            if ($administrator->getActive()) {
                array_push($activeAdministrators, $administrator);
            }

        }

        return $activeAdministrators;
    }

    private function RetrieveData()
    {
        $this->$administratorList = array();

        if (file_exists('Data/administrators.json')) {

            $jsonContent = file_get_contents('Data/administrators.json');

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray) {

                $administrator = new Administrator();

                $administrator->setAdministratorId($valuesArray["administratorId"]);

                $administrator->setFirstName($valuesArray["firstName"]);
                $administrator->setLastName($valuesArray["lastName"]);
                $administrator->setDni($valuesArray["dni"]);
                $administrator->setGender($valuesArray["gender"]);
                $administrator->setBirthDate($valuesArray["birthDate"]);
                $administratort->setEmail($valuesArray["email"]);
                $administrator->setPhoneNumber($valuesArray["phoneNumber"]);
                $administrator->setActive($valuesArray["active"]);

                array_push($this->$administratorList, $administrator);
            }
        }

    }

    private function SaveData()
    {
        $arrayToEncode = array();

        foreach($this->$administratorList as $administrator)
        {            
            $valuesArray["administratorId"] = $administrator->getAdministratorId();

            $valuesArray["firstName"] = $administrator->getFirstName();
            $valuesArray["lastName"] = $administrator->getLastName();
            $valuesArray["dni"] = $administrator->getDni();
            $valuesArray["gender"] = $administrator->getGender();
            $valuesArray["birthDate"] = $administrator->getBirthDate();
            $valuesArray["email"] = $administratort->getEmail();
            $valuesArray["phoneNumber"] = $administrator->getPhoneNumber();
            $valuesArray["active"] = $administrator->getActive();

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        
        file_put_contents('Data/administrator.json', $jsonContent);
    }

}
