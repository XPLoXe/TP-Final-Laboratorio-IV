<?php
namespace DAO;

use Interfaces\IJobPositionDAO as IJobPositionDAO;
use Models\JobPosition as JobPosition;

class JobPositionDAO implements IJobPositionDAO
{
    private $jobPositionList = array();
    private $connection;
    private $tableName = "JobPositions";
    

    public function updateDatabaseFromAPI(){

        $this->RetrieveData();

        foreach($jobPositionList as $jobPosition){

           $DBjobPosition = $this->getJobPositionById($jobPosition->getJobPositionId());
           
           if($DBjobPosition != NULL){

                if( strcmp( $DBjobPosition["description"] , $jobPosition->getDescription() ) != 0 )
                    $this->alterDescription($DBjobPosition["job_position_id"],$jobPosition->getDescription());

                if( $DBjobPosition["career_id"] != $jobPosition->getCareerId() )
                    $this->alterCareerId($DBjobPosition["job_position_id"],$jobPosition->getCareerId());

           }else{

               $this->Add($jobPosition);

           }
           
        }

    }

    public function getJobPositionById($jobPositionId){

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

    public function alterDescription($jobPositionId,$newDescription){

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

    public function alterCarrerId($jobPositionId,$newCareerId){

        try
        {
            $query = "UPDATE ".$this->tableName." SET career_id='".$newCareerId."'WHERE job_position_id='".$jobPositionId."'";

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query);
            
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
            $query = "INSERT INTO ".$this->tableName." (job_position_id, description, career_id) VALUES (:job_position_id, :description, :company_id);";

            $parameters["job_position_id"] = $jobOffer->getJobPositionId();
            $parameters["description"] = $jobOffer->getDescription();
            $parameters["career_id"] = $jobOffer->getCareerId();
 
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

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);
            
            foreach ($resultSet as $row)
            {                
                $jobPosition = new JobOffer();
                $jobPosition->setJobPositionId($row["job_position_id"]);
                $jobPosition->setDescription($row["description"]);
                $jobPosition->setCareerId($row["career_id"]);

                array_push($jobPositionList, $jobOffer);
            }

            return $jobOfferList;
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

        $dataAPI = $this->getStudentsFromApi();

        $arrayToDecode = json_decode($dataAPI, true);

        foreach ($arrayToDecode as $valuesArray) {

            $jobPosition = new JobPosition(); 

            $jobPosition->setJobPositionId($valuesArray["jobPositionId"]); 
            $jobPosition->setCareerId($valuesArray["careerId"]); 
            $jobPosition->setDescription($valuesArray["description"]); 

            array_push($this->jobPositionList, $jobPosition);
        }

    }

}
