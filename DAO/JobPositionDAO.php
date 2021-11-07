<?php
    namespace DAO;

    use DAO\Connection;
    use Interfaces\IJobPositionDAO as IJobPositionDAO;
    use Models\JobPosition as JobPosition;
    use Exception;

    class JobPositionDAO implements IJobPositionDAO
    {
        private $jobPositionList = array();
        private $connection;
        private $tableName = "JobPositions";


        public function UpdateDatabaseFromAPI()
        {
            $careerDAO = new CareerDAO;
            $careerDAO->UpdateDatabaseFromAPI();

            $this->RetrieveData();

            $DBjobPositionList = $this->GetAll(true);

            if (!($this->jobPositionList == $DBjobPositionList))
            {
                $this->SetJobPositionsInactive();

                foreach ($this->jobPositionList as $jobPosition)
                {
                    $flag = false;
                    
                    foreach ($DBjobPositionList as $DBjobPosition)
                    {
                        if ($DBjobPosition->getJobPositionId() == $jobPosition->getJobPositionId())
                        {
                            $flag = true;

                            $this->SetActive($DBjobPosition->getJobPositionId());

                            if (strcmp($DBjobPosition->getDescription(), $jobPosition->getDescription()) != 0)
                                $this->EditDescription($DBjobPosition->getJobPositionId(),$jobPosition->getDescription());

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


        public function SetJobPositionsInactive(): void
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


        public function SetActive(int $jobPositionId): void
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

        public function GetJobPositionById(int $jobPositionId): JobPosition
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE job_position_id = :job_position_id ;";

                $parameters["job_position_id"] = $jobPositionId;

                $this->connection = Connection::GetInstance();

                $row = $this->connection->Execute($query, $parameters)[0];
            
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


        public function IsActive(int $jobPositionId): bool
        {
            try
            {    
                $query = "SELECT active FROM ".$this->tableName." WHERE job_position_id = :job_position_id ;";

                parameters["job_position_id"] = $jobPositionId;

                $this->connection = Connection::GetInstance();
                
                $isActive = $this->connection->Execute($query, $parameters)[0]["active"];

                return $isActive;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function EditDescription(int $jobPositionId, string $newDescription): void
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET description = :description WHERE job_position_id = :job_position_id ;";

                $parameters["description"] = $newDescription;
                $parameters["job_position_id"] = $jobPositionId;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function Add(JobPosition $jobPosition): void
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


        public function GetAll(bool $includeInactive = false): array
        {
            try
            {
                $jobPositionList = array();

                $query = "SELECT * FROM ".$this->tableName." ";

                if ($includeInactive == false)
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


        public function GetIdByDescription(string $description): int
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


        private function GetJobPositionsFromApi()
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

            $dataAPI = $this->GetJobPositionsFromApi();

            $arrayToDecode = json_decode($dataAPI, true);

            foreach ($arrayToDecode as $valuesArray)
            {
                $jobPosition = new JobPosition($valuesArray["jobPositionId"]); 
                $jobPosition->setCareerId($valuesArray["careerId"]); 
                $jobPosition->setDescription($valuesArray["description"]); 

                array_push($this->jobPositionList, $jobPosition);
            }
        }


        public function GetJobPositionByName(string $name): JobPosition
        {
            try
            {    
                $query = "SELECT * FROM ".$this->tableName." WHERE description LIKE '%$name%'";
    
                $this->connection = Connection::GetInstance();
    
                $filterJobPosition = $this->connection->Execute($query);

                $jobPositionList = array();

                if (!empty($filterJobPosition))
                {
                    foreach ($filterJobPosition as $row)
                    {
                        if ($row["active"] == 1)
                        {                            
                            $jobPosition = new JobPosition($row["job_position_id"]);
                            $jobPosition->setCareerId($row["career_id"]); 
                            $jobPosition->setDescription($row["description"]); 

                            array_push($jobPositionList, $jobPosition);
                        }
                    }
                }
                return $jobPositionList;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }
    }