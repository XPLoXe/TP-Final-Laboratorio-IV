<?php
namespace DAO;

use Interfaces\ICarrerDAO as ICarrerDAO;
use Models\Carrer as Carrer;

class CarrerDAO implements ICarrertDAO
{
    private $carrerList = array();

    public function GetAll()
    {
        $this->RetrieveData();

        return $this->carrerList;
    }

    private function getCarrersFromApi()
    {
        $apiCarrer = curl_init(API_URL . "Carrer");

        curl_setopt($apiCarrer, CURLOPT_HTTPHEADER, array('x-api-key:' . API_KEY));
        curl_setopt($apiCarrer, CURLOPT_RETURNTRANSFER, true);

        $dataAPI = curl_exec($apiCarrer);

        return $dataAPI;

    }

    public function getCarrerByName($name)//?
    {

        $this->RetrieveData();

        foreach ($carrerList as $carrer) {

            if ($carrer->getName() == $name) {
                return $carrer;
            }

        }

        return null;
    }

    public function getActiveCarrers()
    {

        $this->RetrieveData();

        $activeCarrers = array();

        foreach ($this->carrerList as $carrer) {

            if ($carrer->isActive()) {
                array_push($activeCarrers, $carrer);
            }

        }

        return $activeCarrers;
    }

    public function getCarrerById($id){

        $this->RetrieveData();

        foreach ($this->carrerList as $carrer) {

            if ($carrer->getCarrerId() == $id) {
                return $carrer;
            }

        }

        return null;

    }

    private function RetrieveData()
    {
        $this->carrerList = array();

        $dataAPI = $this->getCarrersFromApi();

        $arrayToDecode = json_decode($dataAPI, true);

        foreach ($arrayToDecode as $valuesArray) {

            $carrer = new Carrer(); 

            $carrer->setCarrerId($valuesArray["carrerId"]);

            $carrer->setDescription($valuesArray["description"]);
            $carrer->setName($valuesArray["name"]);
            $carrer->setActive($valuesArray["active"]);
           
            array_push($this->carrerList, $carrer);
        }

    }

}
