<?php
namespace DAO;

use Interfaces\ICareerDAO as ICareerDAO;
use Models\Career as Career;

class CareerDAO implements ICareerDAO
{
    private $careerList = array();

    public function GetAll()
    {
        $this->RetrieveData();

        return $this->careerList;
    }

    private function getCareersFromApi()
    {
        $apiCareer = curl_init(API_URL . "Career");

        curl_setopt($apiCareer, CURLOPT_HTTPHEADER, array('x-api-key:' . API_KEY));
        curl_setopt($apiCareer, CURLOPT_RETURNTRANSFER, true);

        $dataAPI = curl_exec($apiCareer);

        return $dataAPI;

    }

    public function getCareerByName($name)//?
    {

        $this->RetrieveData();

        foreach ($careerList as $career) {

            if ($career->getName() == $name) {
                return $career;
            }

        }

        return null;
    }

    public function getActiveCareers()
    {

        $this->RetrieveData();

        $activeCareers = array();

        foreach ($this->careerList as $career) {

            if ($career->isActive()) {
                array_push($activeCareers, $career);
            }

        }

        return $activeCareers;
    }

    public function getCareerById($id){

        $this->RetrieveData();

        foreach ($this->careerList as $career) {

            if ($career->getCareerId() == $id) {
                return $career;
            }

        }

        return null;

    }

    private function RetrieveData()
    {
        $this->careerList = array();

        $dataAPI = $this->getCareersFromApi();

        $arrayToDecode = json_decode($dataAPI, true);

        foreach ($arrayToDecode as $valuesArray) {

            $career = new Career(); 

            $career->setCareerId($valuesArray["careerId"]);

            $career->setDescription($valuesArray["description"]);
            $career->setName($valuesArray["name"]);
            $career->setActive($valuesArray["active"]);
           
            array_push($this->careerList, $career);
        }

    }

}
