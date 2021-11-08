<?php
    namespace DAO;

    use DAO\Connection as Connection;
    use DAO\JobPositionDAO as JobPositionDAO;
    use DAO\StudentDAO as StudentDAO;
    use Models\JobOffer as JobOffer;
    use Models\JobPosition as JobPosition;
    use Models\Company as Company;
    use Models\User as User;
    use Utils\Utils as Utils;
    use DateTime;
    use Exception as Exception;

    class JobOfferDAO
    {
        private $connection;
        private $tableName = "JobOffers";

        public function Add(JobOffer $jobOffer): void
        {
            try
            {
                $query = "INSERT INTO ".$this->tableName." (job_position_id, company_id, description, publication_date, expiration_date) VALUES (:job_position_id, :company_id, :description, :publication_date, :expiration_date) ;";

                $parameters["job_position_id"] = $jobOffer->getJobPositionId();
                $parameters["company_id"] = $jobOffer->getCompanyId();
                $parameters["description"] = $jobOffer->getDescription();
                $parameters["publication_date"] = $jobOffer->getPublicationDate()->format('Y-m-d');
                $parameters["expiration_date"] = $jobOffer->getExpirationDate()->format('Y-m-d');

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }
        

        public function Delete(int $jobOfferId): void
        {
            try
            {
                $query =   "UPDATE ".$this->tableName." SET user_id = NULL, active = :active WHERE job_offer_id = :job_offer_id ;";

                $parameters['job_offer_id'] = $jobOfferId;
                $parameters['active'] = 0;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function Edit(JobOffer $jobOffer)
        {
            try
            {
                $query =   "UPDATE ".$this->tableName." SET job_position_id = :job_position_id, 
                company_id = :company_id, expiration_date = :expiration_date, description = :description 
                WHERE job_offer_id = :job_offer_id ;";

                $parameters['job_offer_id'] = $jobOffer->getJobOfferId();
                $parameters['job_position_id'] = $jobOffer->getJobPositionId();
                $parameters['company_id'] = $jobOffer->getCompanyId();
                $parameters['expiration_date'] = $jobOffer->getExpirationDate()->format("Y-m-d");
                $parameters['description'] = $jobOffer->getDescription();

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        private function UpdateDatabase(): void
        {
            try
            {
                $jobOfferList = $this->GetAll(FILTER_ALL);

                $jobPositionDAO = new JobPositionDAO();

                $jobPositionDAO->UpdateDatabaseFromAPI();

                foreach ($jobOfferList as $jobOffer)
                {
                    if (!$jobOffer->getCompany()->isActive() || 
                        !$this->jobPositionDAO->IsActive($jobOffer->getJobPositionId()))
                    {
                        $this->ChangeActive($jobOffer->getJobOfferId(), false);
                    }
                }
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function TryDatabaseUpdate(): void
        {
            if (file_exists(UPDATE_FILE_PATH))
            {
                $lastUpdate = date(file_get_contents(UPDATE_FILE_PATH));
                $today = date("Y-m-d");

                if ($lastUpdate < $today)
                {
                    $this->UpdateDatabase();
                    file_put_contents(UPDATE_FILE_PATH, $today);
                }
            }
            else
            {
                $this->UpdateDatabase();
                file_put_contents(UPDATE_FILE_PATH, $today);
            }
        }


        public function GetAllAvailable()
        {
            try
            {
                $jobOfferList = array();
                //change the name of the columns with as
                $query = "SELECT jo.user_id, jo.description as job_offer_description ,jo.publication_date,jo.expiration_date,
                                 jo.job_offer_id, jo.active, cp.name, cp.city, jp.description as job_position_description, cr.description,
                                 jp.job_position_id, cr.career_id, cp.company_id
                            FROM JobOffers jo
                      INNER JOIN Companies cp on jo.company_id = cp.company_id
                      INNER JOIN JobPositions jp on jo.job_position_id = jp.job_position_id
                      INNER JOIN Careers cr on jp.career_id = cr.career_id
                           WHERE jo.active = :active AND jo.expiration_date > curdate() AND user_id IS NULL ;";

                $parameters["active"] = true;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);

                if (!empty($resultSet))
                {
                    foreach ($resultSet as $row)
                    {
                        $jobOffer = new JobOffer();
                        
                        $jobOffer->setJobOfferId($row["job_offer_id"]);

                        $jobPosition = new JobPosition($row['job_position_id']);
                        $jobPosition->setCareerId($row['career_id']);
                        $jobPosition->setDescription($row['job_position_description']);
                        $jobOffer->setJobPosition($jobPosition);
                        
                        $company = new Company($row['company_id']);
                        $company->setName($row["name"]);
                        $company->setCity($row["city"]);
                        $jobOffer->setCompany($company);

                        $jobOffer->setDescription($row["job_offer_description"]);
                        $jobOffer->setPublicationDate(new DateTime($row["publication_date"]));
                        $jobOffer->setExpirationDate(new DateTime($row["expiration_date"]));

                        array_push($jobOfferList ,$jobOffer);
                    }
                }

                return $jobOfferList;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function GetAllUnavailable(): array
        {
            try
            {
                $jobOfferList = array();
                //change the name of the columns with as
                $query = "SELECT jo.user_id, jo.description as job_offer_description ,jo.publication_date,jo.expiration_date,
                                 jo.job_offer_id, jo.active, cp.name, cp.city, jp.description as job_position_description, cr.description,
                                 jp.job_position_id, cr.career_id, cp.company_id
                            FROM JobOffers jo
                      INNER JOIN Companies cp on jo.company_id = cp.company_id
                      INNER JOIN JobPositions jp on jo.job_position_id = jp.job_position_id
                      INNER JOIN Careers cr on jp.career_id = cr.career_id
                           WHERE jo.active = :active AND jo.expiration_date > curdate() AND user_id IS NOT NULL ;";

                $parameters["active"] = true;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);

                if (!empty($resultSet))
                {
                    foreach ($resultSet as $row)
                    {
                        $jobOffer = new JobOffer();
                        
                        $jobOffer->setJobOfferId($row["job_offer_id"]);

                        $jobPosition = new JobPosition($row['job_position_id']);
                        $jobPosition->setCareerId($row['career_id']);
                        $jobPosition->setDescription($row['job_position_description']);
                        $jobOffer->setJobPosition($jobPosition);
                        
                        $company = new Company($row['company_id']);
                        $company->setName($row["name"]);
                        $company->setCity($row["city"]);
                        $jobOffer->setCompany($company);

                        $jobOffer->setDescription($row["job_offer_description"]);
                        $jobOffer->setPublicationDate(new DateTime($row["publication_date"]));
                        $jobOffer->setExpirationDate(new DateTime($row["expiration_date"]));

                        array_push($jobOfferList ,$jobOffer);
                    }
                }

                return $jobOfferList;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function GetAll( $filter )
        {
            try
            {                
                $query = "SELECT jo.user_id, jo.description as job_offer_description ,jo.publication_date,jo.expiration_date,
                                    jo.job_offer_id, jo.active, cp.name, cp.city, jp.description as job_position_description, cr.description as career_description, 
                                    cp.active as company_active, jp.job_position_id, cr.career_id, cp.company_id, jp.career_id
                        FROM JobOffers jo
                        INNER JOIN Companies cp on jo.company_id = cp.company_id
                        INNER JOIN JobPositions jp on jo.job_position_id = jp.job_position_id
                        INNER JOIN Careers cr on jp.career_id = cr.career_id
                        WHERE jo.active = :active ";

                if($filter == FILTER_ALL){

                    $query .=";";

                }else if($filter == FILTER_STUDENT){

                    $query .="AND jo.expiration_date > curdate() AND cr.career_id = :career_id AND user_id IS NULL ;";
                    $studentDAO = new StudentDAO();
                    $parameters["career_id"] = $studentDAO->GetCareerIdByStudentId($_SESSION["loggedUser"]->getAssociatedId());
                }

                $parameters["active"] = true;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);

                $jobOfferList = array();

                if ($resultSet)
                {
                    
                    foreach ($resultSet as $row)
                    {
                        $jobOffer = new JobOffer();

                        $jobOffer->setUserId($row['user_id']);
                        
                        $jobOffer->setJobOfferId($row["job_offer_id"]);

                        $jobPosition = new JobPosition($row['job_position_id']);
                        $jobPosition->setDescription($row['job_position_description']);
                        $jobPosition->setCareerId($row['career_id']);
                        $jobOffer->setJobPosition($jobPosition);

                        $company = new Company($row['company_id']);
                        $company->setName($row['name']);
                        $company->setCity($row['city']);
                        $company->setActive($row['company_active']);
                        $jobOffer->setCompany($company);

                        $jobOffer->setDescription($row["job_offer_description"]);
                        $jobOffer->setPublicationDate(new DateTime($row["publication_date"]));
                        $jobOffer->setExpirationDate(new DateTime($row["expiration_date"]));
                        $jobOffer->setActive($row["active"]);

                        array_push($jobOfferList ,$jobOffer);
                    }
                }
                return $jobOfferList;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function Apply(int $jobOfferId, int $userId): void
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET user_id = :user_id WHERE job_offer_id = :job_offer_id ;";
                $parameters["user_id"] = $userId;
                $parameters["job_offer_id"] = $jobOfferId;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
                
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
            
        }


        public function DeleteApplication(int $jobOfferId): void
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET user_id = :user_id WHERE job_offer_id = :job_offer_id ;";

                $parameters["user_id"] = NULL;
                $parameters["job_offer_id"] = $jobOfferId;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
                
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        } 


        public function IsUserIdInOffer(int $userId): bool
        {
            try
            {
                $query = "SELECT 'user_id' FROM ".$this->tableName." WHERE user_id = :user_id ;";

                $parameters["user_id"] = $userId;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);
                
                if (empty($resultSet))
                    return true;
                else
                    return false;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function ChangeActive(int $jobOfferId, bool $active): void
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET active = :active WHERE job_offer_id = :job_offer_id ;";

                $parameters["job_offer_id"] = $jobOfferId;
                $parameters['active'] = $active;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        public function GetJobOfferByUserID($userId)
        {
            {
                try
                {
                    $jobOfferList = array();
                    //change the name of the columns with as
                    $query = "SELECT jo.user_id, jo.description as job_offer_description ,jo.publication_date,jo.expiration_date,
                                     jo.job_offer_id, jo.active, cp.name, cp.city, jp.description as job_position_description, cr.description,
                                     jp.job_position_id, cr.career_id, cp.company_id
                                FROM JobOffers jo
                          INNER JOIN Companies cp on jo.company_id = cp.company_id
                          INNER JOIN JobPositions jp on jo.job_position_id = jp.job_position_id
                          INNER JOIN Careers cr on jp.career_id = cr.career_id
                               WHERE jo.active = :active AND jo.user_id = :userId;";
    
                    $parameters['active'] = true;
                    $parameters['userId'] = $userId;
                    
                    $this->connection = Connection::GetInstance();
    
                    $resultSet = $this->connection->Execute($query, $parameters);
                    
                    $jobOffer = new JobOffer();

                    if (!empty($resultSet))
                    {
                        foreach ($resultSet as $row)
                        {
                            $jobOffer->setJobOfferId($row["job_offer_id"]);

                            $jobPosition = new JobPosition($row['job_position_id']);
                            $jobPosition->setCareerId($row['career_id']);
                            $jobPosition->setDescription($row['job_position_description']);
                            $jobOffer->setJobPosition($jobPosition);
                            
                            $company = new Company($row['company_id']);
                            $company->setName($row["name"]);
                            $company->setCity($row["city"]);
                            $jobOffer->setCompany($company);

                            $jobOffer->setDescription($row["job_offer_description"]);
                            $jobOffer->setPublicationDate(new DateTime($row["publication_date"]));
                            $jobOffer->setExpirationDate(new DateTime($row["expiration_date"]));
                        }
                    }
                    else
                    {
                        return null;
                    }
    
                    return $jobOffer;
                }
                catch (Exception $ex)
                {
                    throw $ex;
                }
            }
        }

        public function GetJobOfferById($jobOfferList,$jobOfferId)
        {

            foreach($jobOfferList as $jobOffer){

                if($jobOffer->getJobOfferId() == $jobOfferId)
                    return $jobOffer;

            }

            return false;
        }
    }   
