<?php
    namespace Models;

    use DateTime;

    class JobOffer
    {
        private int $jobOfferId;
        private JobPosition $jobPosition;
        private int $user_id;
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
            $this->getJobPosition()->setJobPositionId($jobPositionId);
        }


        public function getUserId(): int
        {
            return $this->user_id;
        }


        public function setUserId(int $user_id): void
        {
            $this->user_id = $user_id;
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


        public function setCompanyId(int $companyId) 
        {
            $this->getCompany()->setCompanyId($companyId);
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
