<?php
    namespace DAO;

    use Interfaces\IJobOfferDAO as IJobOfferDAO;
    use DAO\Connection;
    use Models\JobOffer;
    use Models\JobPosition;
    use Utils\Utils;
    use DateTime;

    class JobOfferDAO
    {

        private $connection;
        private $tableName = "JobOffers";

        public function Add(JobOffer $jobOffer)
        {
            try
            {
                $query = "INSERT INTO ".$this->tableName." (job_position_id, company_id, description, publication_date, expiration_date) VALUES (:job_position_id, :company_id, :description, :publication_date, :expiration_date);";

                $parameters["job_position_id"] = $jobOffer->getJobPositionId();
                $parameters["company_id"] = $jobOffer->getCompanyId();
                $parameters["description"] = $jobOffer->getDescription();
                $parameters["publication_date"] = $jobOffer->getPublicationDate();
                $parameters["expiration_date"] = $jobOffer->getExpirationDate();

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
                $jobOfferList = array();

                $query =   "SELECT * FROM ".$this->tableName.";";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                if ($resultSet)
                {
                    foreach ($resultSet as $row)
                    {
                        if ($row["active"] == 1)
                        {
                            $jobOffer = new JobOffer();
                            $company = new Company($row["company_id"]);
                            $jobPosition = new JobPosition($row["job_position_id"]);
                            $applicant = new User($row["user_id"]);
    
                            $jobOffer->setJobOfferId($row["job_offer_id"]);
                            $jobOffer->setJobPosition($jobPosition);
                            $jobOffer->setApplicant($applicant);
                            $jobOffer->setCompany($company);
                            $jobOffer->setDescription($row["job_offer_description"]);
                            $jobOffer->setPublicationDate($row["publication_date"]);
                            $jobOffer->setExpirationDate($row["expiration_date"]);
                            $jobOffer->setActive($row["active"]);
    
                            array_push($jobOfferList, $jobOffer);
                        }
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
                $query = "SELECT * FROM ".$this->tableName." WHERE user_id='".$userId."'";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
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
                $query = "SELECT * FROM ".$this->tableName." WHERE job_position_id='".$jobPositionId."'";

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


        public function getJobOfferById($jobOfferId)
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE job_offer_id='".$jobOfferId."'";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                return $resultSet;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function getJobOfferByCompanyId($companyId)
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


        public function getJobOfferByCareerId($careerId)// no va xq joboffer no tiene careerId
        //hay q hacer el inner join necesario
        {

            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE career_id='".$careerId."'";

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

        //Alter
        public function setUserId($jobOfferId,$user_id)
        {

            try
            {
                $query = "UPDATE ".$this->tableName." SET user_id='".$user_Id."'WHERE job_offer_id='".$jobOfferId."'";

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query);
                
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }
    }   