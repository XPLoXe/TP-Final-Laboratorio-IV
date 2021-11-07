<?php
    namespace DAO;

    use DAO\Connection;
    use Interfaces\ICareerDAO as ICareerDAO;
    use Models\Career as Career;
    use Exception;

    class CareerDAO implements ICareerDAO
    {
        private $careerList = array();
        private $connection;
        private $tableName = "Careers";


        public function Add(Career $career): void
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

        /* public function Delete()
        {

        }

        public function Edit()
        {

        } */

        


        public function UpdateDatabaseFromAPI(): void
        {
            $this->RetrieveData();

            $DBcareerList = $this->GetAll();

            if (!($this->careerList == $DBcareerList) )
            {
                foreach ($this->careerList as $career)
                {
                    $flag = false;
                    
                    foreach ($DBcareerList as $DBcareer)
                    {
                        if ($DBcareer->getCareerId() == $career->getCareerId())
                        {
                            $flag = true;

                            if (strcmp($DBcareer->getDescription(), $career->getDescription()) != 0)
                                $this->EditDescription($DBcareer->getCareerId(), $career->getDescription());

                            if ($DBcareer->isActive() != $career->isActive())
                                $this->ChangeActive($DBcareer->getCareerId(), $career->isActive());
                        }
                        if ($flag == true)
                            break;
                    }
                    if ($flag == false)
                        $this->Add($career);
                }
            }
        }


        private function EditDescription(int $careerId, string $newDescription): void
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET description = :new_description WHERE career_id = :career_id ;";

                $parameters["new_description"] = $newDescription;
                $parameters["career_id"] = $careerId;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function ChangeActive(int $careerId, bool $isActive): void
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET active = :active WHERE career_id = :career_id ;";

                $parameters["career_id"] = $careerId;
                $parameters["active"] = $isActive;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
                
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function GetAll(): array
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


        public function GetCareerById($id): Career
        {
            try
            {
                $DBcareerList = array();

                $query = "SELECT * FROM ".$this->tableName." WHERE career_id = :id;";

                $parameters['id'] = $id;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);
                
                foreach ($resultSet as $row)
                {                
                    $career = new Career();
                    $career->setCareerId($row["career_id"]);
                    $career->setDescription($row["description"]);
                    $career->setActive($row["active"]);
                }

                return $career;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        


        private function GetCareersFromApi()
        {
            $apiCareer = curl_init(API_URL . "Career");

            curl_setopt($apiCareer, CURLOPT_HTTPHEADER, array('x-api-key:' . API_KEY));
            curl_setopt($apiCareer, CURLOPT_RETURNTRANSFER, true);

            $dataAPI = curl_exec($apiCareer);

            return $dataAPI;
        }


        private function RetrieveData(): void
        {
            $this->careerList = array();

            $dataAPI = $this->GetCareersFromApi();

            $arrayToDecode = json_decode($dataAPI, true);

            foreach ($arrayToDecode as $valuesArray)
            {
                $career = new Career();
                $career->setCareerId($valuesArray["careerId"]);
                $career->setDescription($valuesArray["description"]);
                $career->setActive($valuesArray["active"]);
            
                array_push($this->careerList, $career);
            }
        }
    }
