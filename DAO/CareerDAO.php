<?php
namespace DAO;

use Exception as Exception;
use Interfaces\ICareerDAO as ICareerDAO;
use DAO\Connection;
use Models\Career as Career;

class CareerDAO implements ICareerDAO
{
    private $careerList = array();
    private $connection;
    private $tableName = "Careers";


    public function updateDatabaseFromAPI()
    {
        $this->RetrieveData();

        $DBcareerList = $this->GetAll();

        if( !($this->careerList == $DBcareerList) ){

            foreach($this->careerList as $career){

                $flag = false;
                
                foreach($DBcareerList as $DBcareer){

                    if( $DBcareer->getCareerId() == $career->getCareerId() ){

                        $flag = true;

                        if (strcmp($DBcareer->getDescription(), $career->getDescription()) != 0)
                            $this->editDescription($DBcareer->getCareerId(), $career->getDescription());

                        if ($DBcareer->isActive() != $career->isActive())
                            $this->alterActive($DBcareer->getCareerId(), $career->isActive());
                    }
                    if ($flag == true)
                        break;
                }
                if ($flag == false)
                    $this->Add($career);
            }
        }
    }


    public function editDescription(int $careerId, string $newDescription)
    {
        try
        {
            $query = "UPDATE ".$this->tableName." SET description='".$newDescription."'WHERE career_id='".$careerId."'";

            //$parameters["description"] = $newDescription;
            //$parameters["careerId"] = $careerId;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query);
            
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }


    public function alterActive($careerId,$newActive)
    {
        try
        {
            $query = "UPDATE ".$this->tableName." SET active='".$newActive."'WHERE career_id='".$careerId."'";

            //$parameters["active"] = $newActive;
            //$parameters["careerId"] = $careerId;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query);
            
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
            $DBcareerList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);
            
            foreach ($resultSet as $row)
            {                
                $career = new Career();
                $career->setCareerId($row["career_id"]);
                $career->setDescription($row["description"]);
                $career->setActive($row["active"]);

                array_push($DBcareerList,  $career);
            }

            return $DBcareerList;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    
    }

    public function Add(Career $career)
    {

        try
        {
            $query = "INSERT INTO ".$this->tableName." (career_id, description, active) VALUES (:career_id, :description, :active);";

            $parameters["career_id"] = $career->getCareerId();
            $parameters["description"] = $career->getDescription();
            $parameters["active"] = $career->isActive();
 
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch (Exception $ex)
        {
            throw $ex;
        }


    }

    private function getCareersFromApi()
    {
        $apiCareer = curl_init(API_URL . "Career");

        curl_setopt($apiCareer, CURLOPT_HTTPHEADER, array('x-api-key:' . API_KEY));
        curl_setopt($apiCareer, CURLOPT_RETURNTRANSFER, true);

        $dataAPI = curl_exec($apiCareer);

        return $dataAPI;

    }

    public function getCareerByDescription($description)
    {
    }

    public function getActiveCareers()
    {
    }

    public function getCareerById($careerId)
    {
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
            $career->setActive($valuesArray["active"]);
           
            array_push($this->careerList, $career);
        }

    }

}
