<?php
    namespace Models;

    class JobOffer
    {
        private int $jobOfferId;
        private int $jobPositionId;
        private int $userId;
        private int $companyId;
        private string $description;
        private Date $publicationDate;
        private Date $expirationDate;
        private bool $active;

        public function getJobOfferId()
        {
            return $this->jobOfferId;
        }

        public function setJobOfferId($jobOfferId)
        {
            $this->jobOfferId = $jobOfferId;
        }

        public function getJobPositionId()
        {
            return $this->jobPositionId;
        }

        public function setJobPositionId($jobPositionId)
        {
            $this->jobPositionId = $jobPositionId;
        }

        public function getUserId()
        {
            return $this->userId;
        }

        public function setUserId($userId)
        {
            $this->userId = $userId;
        }

        public function getDescription()
        {
            return $this->description;
        }

        public function setDescription($description)
        {
            $this->description = $description;
        }

        public function getPublicationDate()
        {
            return $this->publicationDate;
        }

        public function setPublicationDate($publicationDate)
        {
            $this->publicationDate = $publicationDate;
        }

        public function getExpirationDate()
        {
            return $this->expirationDate;
        }

        public function setExpirationDate($expirationDate)
        {
            $this->expirationDate = $expirationDate;
        }

        public function isActive()
        {
            return $this->active;
        }

        public function setActive($active)
        {
            $this->active = $active;
        }

        public function getCompanyId()
        {
            return $this->companyId;
        }

        public function setCompanyId($companyId)
        {
            $this->companyId = $companyId;
        }
    }


?>