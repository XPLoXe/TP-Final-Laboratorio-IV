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


        public function updateDatabaseFromAPI()
        {
            $careerDAO = new CareerDAO;
            $careerDAO->updateDatabaseFromAPI();

            $this->RetrieveData();

            $DBjobPositionList = $this->GetAll(true);

            if (!($this->jobPositionList == $DBjobPositionList))
            {
                $this->setInactiveJobPositionsDB();

                foreach ($this->jobPositionList as $jobPosition)
                {
                    $flag = false;
                    
                    foreach ($DBjobPositionList as $DBjobPosition)
                    {
                        if ($DBjobPosition->getJobPositionId() == $jobPosition->getJobPositionId())
                        {
                            $flag = true;

                            $this->setActiveTrue($DBjobPosition->getJobPositionId());

                            if (strcmp($DBjobPosition->getDescription(), $jobPosition->getDescription()) != 0)
                                $this->editDescription($DBjobPosition->getJobPositionId(),$jobPosition->getDescription());

                            if ($DBjobPosition->getCareerId() != $jobPosition->getCareerId())
                                $this->alterCareerId($DBjobPosition->getJobPositionId(),$jobPosition->getCareerId());
                        }
                        if ($flag == true)
                            break;
                    }
                    if ($flag == false)
                        $this->Add($jobPosition);
                }
            }
        }

        public function setInactiveJobPositionsDB()
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET active = :active ;";

                $parameters['active'] = false;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        public function setActiveTrue(int $jobPositionId)
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET active = :active WHERE job_position_id = :job_position_id ;";

                $parameters['job_position_id'] = $jobPositionId;
                $parameters['active'] = true;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        public function getJobPositionById($jobPositionId)
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE job_position_id = '".$jobPositionId."' ;";

                //$parameters["job_position_id"] = $jobPositionId;

                $this->connection = Connection::GetInstance();

                $row = $this->connection->Execute($query)[0];
            
                $jobPosition = new JobPosition($row["job_position_id"]);
                $jobPosition->setCareerId($row["career_id"]);
                $jobPosition->setDescription($row["description"]);

                return $jobPosition;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        public function isActiveById($jobPositionId):bool
        {
            try
            {    
                $query = "SELECT active FROM ".$this->tableName." WHERE job_position_id='".$jobPositionId."'";

                //parameters["job_position_id"]=$jobPositionId;

                $this->connection = Connection::GetInstance();
                
                $isActive = $this->connection->Execute($query)[0]["active"];

                return $isActive;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }

        }

        public function editDescription($jobPositionId,$newDescription)
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET description=':description 'WHERE job_position_id=':job_position_id'";

                $parameters["description"] = $newDescription;
                $parameters["job_position_id"] = $jobPositionId;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query,$parameters);
                
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        public function alterCareerId($jobPositionId, $newCareerId){

            try
            {
                $query = "UPDATE ".$this->tableName." SET career_id=':career_id' WHERE job_position_id=':job_position_id' ";

                $parameters["career_id"] = $newCareerId;
                $parameters["job_position_id"] = $jobPositionId;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query,$parameters);
                
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
                $query = "INSERT INTO ".$this->tableName." (job_position_id, description, career_id) VALUES (:job_position_id, :description, :career_id);";

                $parameters["job_position_id"] = $jobPosition->getJobPositionId();
                $parameters["description"] = $jobPosition->getDescription();
                $parameters["career_id"] = $jobPosition->getCareerId();
    
                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        public function GetAll($giveMeAll = false)
        {
            try
            {
                $jobPositionList = array();

                $query = "SELECT * FROM ".$this->tableName." ";

                //when i call GetAll() i want the active jobpositions
                //when i call GetAll(true) i want all the jobpositions

                if($giveMeAll == false)
                    $query.="WHERE active='1'";
                
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                foreach ($resultSet as $row)
                {                
                    $jobPosition = new JobPosition($row["job_position_id"]);
                    $jobPosition->setCareerId($row["career_id"]);
                    $jobPosition->setDescription($row["description"]);

                    array_push($jobPositionList, $jobPosition);
                }

                return $jobPositionList;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        public function getIdByDescription($description)
        {
            try
            {
                $query = "SELECT job_position_id FROM ".$this->tableName." WHERE description=':description'";

                $parameters["description"] = $description;

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

                $jobPosition = new JobPosition($valuesArray["jobPositionId"]); 
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
                                
                                /* echo "<pre>" , var_dump($row) , "</pre>"; */
                                $jobPosition = new JobPosition($row["job_position_id"]);
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