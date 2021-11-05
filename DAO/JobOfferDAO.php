<?php
    namespace DAO;

    use Exception as Exception;
    use DAO\Connection as Connection;
    use DAO\CompanyDAO as CompanyDAO;
    use DAO\JobPositionDAO as JobPositionDAO;
    use Models\JobOffer as JobOffer;
    use Models\JobPosition as JobPosition;
    use Models\User as User;
    use Models\Company as Company;
    use Utils\Utils as Utils;
    use DateTime;

    class JobOfferDAO
    {
        private $connection;
        private $tableName = "JobOffers";
        private $jobPositionDAO;
        private $companyDAO;

        public function __construct()
        {
            $this->jobPositionDAO = new JobPositionDAO;
            $this->companyDAO = new CompanyDAO;
        }


        public function Add(JobOffer $jobOffer)
        {
            try
            {
                $query = "INSERT INTO ".$this->tableName." (job_position_id, company_id, description, publication_date, expiration_date) VALUES (:job_position_id, :company_id, :description, :publication_date, :expiration_date);";

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
        

        public function Delete(int $jobOfferId)
        {
            try
            {
                $query =   "UPDATE ".$this->tableName." SET active = false WHERE job_offer_id = :job_offer_id;";

                $parameters['job_offer_id'] = $jobOfferId;

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
                WHERE job_offer_id = :job_offer_id;";

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


        private function updateDatabase()
        {
            try
            {
                $jobOfferList = $this->GetAll();

                $this->jobPositionDAO->updateDatabaseFromAPI();

                foreach($jobOfferList as $jobOffer)
                {
                    if (!$jobOffer->getCompany()->isActive() || 
                        !$this->jobPositionDAO->isActiveById($jobOffer->getJobPositionId()))
                    {
                        $this->setActiveById($jobOffer->getJobOfferId(), false);
                    }
                }
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function tryDatabaseUpdate()
        {
            if (file_exists(UPDATE_FILE_PATH))
            {
                $lastUpdate = date(file_get_contents(UPDATE_FILE_PATH));
                $today = date("Y-m-d");

                if ($lastUpdate < $today)
                {
                    $this->updateDatabase();
                    file_put_contents(UPDATE_FILE_PATH, $today);
                }
            }
            else
            {
                $this->updateDatabase();
                file_put_contents(UPDATE_FILE_PATH, $today);
            }
        }


        public function GetAll()
        {
            try
            {
                $jobOfferList = array();
                //change the name of the columns with as
                $query = "SELECT jo.user_id, jo.description as job_offer_description ,jo.publication_date,jo.expiration_date,
                                 jo.job_offer_id, jo.active, cp.name, cp.city, jp.description, cr.description,
                                 jp.job_position_id, cr.career_id, cp.company_id
                        FROM JobOffers jo
                        INNER JOIN Companies cp on jo.company_id = cp.company_id
                        INNER JOIN JobPositions jp on jo.job_position_id = jp.job_position_id
                        INNER JOIN Careers cr on jp.career_id = cr.career_id
                        WHERE jo.active = :active AND jo.expiration_date > curdate() AND user_id IS NULL ;";

                $parameters["active"] = true;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);

                if ($resultSet)
                {
                    foreach ($resultSet as $row)
                    {
                        $jobOffer = new JobOffer();
                        
                        $jobOffer->setJobOfferId($row["job_offer_id"]);
                        $jobOffer->setJobPosition($this->jobPositionDAO->getJobPositionById($row["job_position_id"]));
                        $jobOffer->setCompany($this->companyDAO->getCompanyById($row["company_id"]));
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


        public function getJobOfferByUserId($userId): JobOffer
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE user_id=':user_id'";

                $parameters["user_id"] = $userId;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query,$parameters);
                
                return $resultSet;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function getJobOfferByJobPositionId($jobPositionId)
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE job_position_id=':job_position_id'";

                $parameters["job_position_id"] = $jobPositionId;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                return $resultSet;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function getActiveJobOffers()
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE active='true' AND expiration_date > '".date('d-m-y')."'";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                return $resultSet;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function getJobOfferExpiresToday()
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE expiration_date = '".date('d-m-y')."'";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                return $resultSet;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function getJobOfferById(int $jobOfferId): JobOffer
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE job_offer_id = :job_offer_id AND active = :active ;";

                $this->connection = Connection::GetInstance();

                $parameters['job_offer_id'] = $jobOfferId;
                $parameters['active'] = true;

                $row = $this->connection->Execute($query, $parameters)[0];

                $jobOffer = new JobOffer();
                            
                $jobOffer->setJobOfferId($row["job_offer_id"]);
                $jobOffer->setJobPosition($this->jobPositionDAO->getJobPositionById($row["job_position_id"]));
                $jobOffer->setCompany($this->companyDAO->getCompanyById($row["company_id"]));
                $jobOffer->setDescription($row["description"]);
                $jobOffer->setPublicationDate(new DateTime($row["publication_date"]));
                $jobOffer->setExpirationDate(new DateTime($row["expiration_date"]));
                $jobOffer->setActive($row["active"]);
                
                return $jobOffer;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function getJobOfferByCompanyId(int $companyId)
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE company_id='".$companyId."'";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                return $resultSet;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

  
        public function getIdByUserId()
        {
            try
            {
                $query = "SELECT job_position_id FROM ".$this->tableName." WHERE user_id='".$userId."'";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                return $resultSet["job_position_id"];
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function Apply($jobOfferId,$user_id)//Apply
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET user_id=:user_id WHERE job_offer_id=:job_offer_id";

                $parameters["user_id"] = $user_id;
                $parameters["job_offer_id"] = $jobOfferId;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query,$parameters);
                
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        public function isUserIdInOffer($userId)//para la botonera
        {
            try
            {
                $query = "SELECT 'user_id' FROM ".$this->tableName." WHERE user_id='".$userId."'";

                //$parameters["user_id"] = $userId;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);

                if(empty($resultSet))
                    return true;//is not looking for job
                else
                    return false;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function setActiveById(int $jobOfferId, bool $active)
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
    }   
