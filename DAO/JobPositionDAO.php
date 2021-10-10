<?php
namespace DAO;

use Interfaces\IJobPositionDAO as IJobPositionDAO;
use Models\JobPosition as JobPosition;

class JobPositionDAO implements IJobPositionDAO
{
    private $jobPositionList = array();

    public function GetAll()
    {
        $this->RetrieveData();

        return $this->jobPositionList;
    }

    private function getJobPositionFromApi()
    {
        $apiJobPosition = curl_init(API_URL . "JobPosition");

        curl_setopt($apiJobPosition, CURLOPT_HTTPHEADER, array('x-api-key:' . API_KEY));
        curl_setopt($apiJobPosition, CURLOPT_RETURNTRANSFER, true);

        $dataAPI = curl_exec($apiJobPosition);

        return $dataAPI;
    }

    public function getJobPositionById($id)
    {

        $this->RetrieveData();

        foreach ($this->jobPositionList as $jobPosition) {

            if ($jobPosition->getJobPositionId() == $id) {
                return $jobPosition;
            }

        }

        return null;
    }

    private function RetrieveData()
    {
        $this->jobPositionList = array();

        $dataAPI = $this->getStudentsFromApi();

        $arrayToDecode = json_decode($dataAPI, true);

        foreach ($arrayToDecode as $valuesArray) {

            $jobPosition = new JobPosition(); 

            $jobPosition->setJobPositionId($valuesArray["jobPositionId"]); //PK
            $jobPosition->setCareerId($valuesArray["careerId"]); //FK
            $jobPosition->setCompanyId($valuesArray["companyId"]); //FK

            array_push($this->jobPositionList, $jobPosition);
        }

    }

}
