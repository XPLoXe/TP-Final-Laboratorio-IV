<?php
namespace DAO;

use Exception as Exception;
use Interfaces\IJobPositionDAO as IJobPositionDAO;
use DAO\Connection;
use Models\JobPosition as JobPosition;

class JobPositionDAO implements IJobPositionDAO
{
    private $jobPositionList = array();
    private $connection;
    private $tableName = "JobPositions";
    

    public function updateDatabaseFromAPI(){

        $this->RetrieveData();

        //$DBjobPositionList = $this->GetAll();

        if( !($this->jobPositionList === $DBjobPositionList) ){

            $DBjobPositionList = $this->setInactiveArrayJobPositions($DBjobPositionList);//Pongo todos los active en 0

            foreach($this->jobPositionList as $jobPosition){

                $flag=false;
                
                foreach($DBjobPositionList as $DBjobPosition){

                    if( $DBjobPosition->getJobPositionId() == $jobPosition->getJobPositionId() ){

                        $flag = true;

                        $DBjobPosition->setActive(true);//como esta en la api el active tiene q ponerse en 1
               
                        if( strcmp( $DBjobPosition->getDescription() , $jobPosition->getDescription() ) != 0 )
                            $this->alterDescription($DBjobPosition->getJobPositionId(),$jobPosition->getDescription());

                        if( $DBjobPosition->getCareerId() != $jobPosition->getCareerId() )//Si esto sucede, debo modificar la tabla careerJobPosition
                            $this->alterCareerId($DBjobPosition->getJobPositionId(), $DBjobPosition->getCareerId(),$jobPosition->getCareerId());
        
                    }

                    if($flag)
                        break;

                }

                if(!$flag)
                    $this->Add($jobPosition);//modificar careerJobPosition
                    
            }
        }
    }


    public function setInactiveArrayJobPositions($DBjobPositionList)//Manera q tengo de saber si un registro de la API fue eliminado y actualizarlo en la BD
    {
        foreach($DBjobPositionList as $DBjobPosition){

            $DBjobPosition->setActive(false);
        }

        return $DBjobPositionList;
    }


    public function getJobPositionById($jobPositionId)
    {
        try
        {
            $query = "SELECT * FROM ".$this->tableName." WHERE job_position_id='".$jobPositionId."'";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);
            
            return $resultSet;//Tengo q averiguar q pasa si no se encuentra el registro a buscar, me encantaria q me retorne un NULL
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }


    public function alterDescription($jobPositionId,$newDescription)
    {
        try
        {
            $query = "UPDATE ".$this->tableName." SET description='".$newDescription."'WHERE job_position_id='".$jobPositionId."'";

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query);
            
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }


    public function alterCareerId($jobPositionId, $oldCareerId, $newCareerId){

        try
        {
            $query = "UPDATE careerjobpositions SET career_id='".$newCareerId."
                    'WHERE job_position_id='".$jobPositionId."' AND career_id='".$oldCareerId."'";

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query);
            
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }


    public function insertCareerJobPosition($jobPositionId,$careerId){

        try
        {
            $query = "INSERT INTO careerjobpositions (career_id,job_position_id) VALUES (:career_id, :job_position_id);";

            $parameters["career_id"] = $careerId;
            $parameters["job_position_id"] = $jobPositionId;
 
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch (Exception $ex)
        {
            throw $ex;
        }

    }

    public function Add(JobPosition $jobPosition)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (job_position_id, description) VALUES (:job_position_id, :description);";

            $parameters["job_position_id"] = $jobPosition->getJobPositionId();
            $parameters["description"] = $jobPosition->getDescription();

            $this->insertCareerJobPosition($jobPosition->getJobPositionId(),$jobPosition->getCareerId());//Este metodo inserta en careerJobPositions
 
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
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
            $jobPositionList = array();

            $query = "SELECT * FROM ".$this->tableName." WHERE active=true";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $row)
            {                
                $jobPosition = new JobPosition();
                $jobPosition->setCareerId($row["career_id"]);
                $jobPosition->setDescription($row["description"]);
                $jobPosition->setActive($row["active"]);
                $jobPosition->setJobPositionId($row["job_position_id"]);

                $jobPositionList[$jobPosition->getJobPositionId()] = $jobPosition;
            }

            return $jobPositionList;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }

    public function getIdByDescription($description)//lo uso cuando agrego una nueva job offer
    {
        try
        {
            $query = "SELECT job_position_id FROM ".$this->tableName." WHERE description='".$description."'";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);
            
            return $resultSet;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }

    }

    private function getJobPositionFromApi()
    {
        $apiJobPosition = curl_init(API_URL . "JobPosition");

        curl_setopt($apiJobPosition, CURLOPT_HTTPHEADER, array('x-api-key:' . API_KEY));
        curl_setopt($apiJobPosition, CURLOPT_RETURNTRANSFER, true);

        $dataAPI = curl_exec($apiJobPosition);

        return $dataAPI;
    }

    private function RetrieveData()
    {
        $this->jobPositionList = array();

        $dataAPI = $this->getJobPositionFromApi();

        $arrayToDecode = json_decode($dataAPI, true);

        foreach ($arrayToDecode as $valuesArray) {

            $jobPosition = new JobPosition(); 

            $jobPosition->setJobPositionId($valuesArray["jobPositionId"]); 
            $jobPosition->setCareerId($valuesArray["careerId"]); 
            $jobPosition->setDescription($valuesArray["description"]); 

            array_push($this->jobPositionList, $jobPosition);
        }
    }

    public function getJobPositionByName($name)
        {
            try
            {    
                $query = "SELECT * FROM ".$this->tableName." WHERE description LIKE '%$name%'";
    
                $this->connection = Connection::GetInstance();
    
                $filterJobPosition = $this->connection->Execute($query);

                $jobPositionList = array();

                if(!empty($filterJobPosition)){

                    foreach ($filterJobPosition as $row)
                    {
                        if ($row["active"] == 1)
                        {
                            $jobPosition = new JobPosition(); 

                            /* echo "<pre>" , var_dump($row) , "</pre>"; */

                            $jobPosition->setJobPositionId($row["job_position_id"]); 
                            $jobPosition->setCareerId($row["career_id"]); 
                            $jobPosition->setDescription($row["description"]); 

                            array_push($jobPositionList, $jobPosition);
                        }
                    }
                }

                /* echo "<pre>" , var_dump($jobPositionList) , "</pre>"; */

                return $jobPositionList;
    
            }
            catch (Exception $ex)
            {
                throw $ex;
            }

        }
}