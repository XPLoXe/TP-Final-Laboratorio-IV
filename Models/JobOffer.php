<?php
    namespace Models;

    use DateTime;

    class JobOffer
    {
        private int $jobOfferId;
        private JobPosition $jobPosition;
        private int $userId;
        private Company $company;
        private string $description;
        private DateTime $publicationDate;
        private DateTime $expirationDate;
        private bool $active;


        public function getJobOfferId(): int
        {
            return $this->jobOfferId;
        }


        public function setJobOfferId(int $jobOfferId): void
        {
            $this->jobOfferId = $jobOfferId;
        }


        public function getJobPosition(): JobPosition
        {
            return $this->jobPosition;
        }


        public function setJobPosition(JobPosition $jobPosition): void
        {
            $this->jobPosition = $jobPosition;
        }


        public function getJobPositionId(): int
        {
            return $this->jobPosition->getJobPositionId();
        }

        
        public function setJobPositionId(int $jobPositionId): void
        {
            if (!isset($this->jobPosition))
                $this->jobPosition = new JobPosition($jobPositionId);
            else
                $this->jobPosition->setJobPositionId($jobPositionId);
        }


        public function getUserId(): int
        {
            if (isset($this->userId))
                return $this->userId;
            else
                return null;
        }


        public function setUserId(?int $userId)
        {
            if (!is_null($userId))
                $this->userId = $userId;
        }


        public function getCompany(): Company
        {
            return $this->company;
        }
    

        public function setCompany(Company $company): void
        {
            $this->company = $company;
        }


        public function getCompanyId(): int
        {
            return $this->company->getCompanyId();
        }


        public function setCompanyId(int $companyId): void
        {
            if (!isset($this->company))
                $this->company = new Company($companyId);
            else
                $this->company->setCompanyId($companyId);
        }


        public function getDescription(): string
        {
            return $this->description;
        }

        public function setDescription(string $description): void
        {
            $this->description = $description;
        }


        public function getPublicationDate(): DateTime
        {
            return $this->publicationDate;
        }


        public function setPublicationDate(DateTime $publicationDate): void
        {
            $this->publicationDate = $publicationDate;
        }


        public function getExpirationDate(): DateTime
        {
            return $this->expirationDate;
        }


        public function setExpirationDate(DateTime $expirationDate): void
        {
            $this->expirationDate = $expirationDate;
        }


        public function isActive(): bool
        {
            return $this->active;
        }


        public function setActive(bool $active): void
        {
            $this->active = $active;
        }
    }
