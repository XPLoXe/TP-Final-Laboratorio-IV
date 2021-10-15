<?php
    namespace Models;

    class JobPosition
    {
        private int $jobPositionId;
        private int $careerId;
        private int $companyId;
        private string $name;
        private string $description;
        private bool $active;

        
        public function getJobPositionId(): int
        {
            return $this->jobPositionId;
        }
    
        public function setJobPositionId($jobPositionId): void
        {
            $this->jobPositionId = $jobPositionId;
        }
        
        public function getCareerId(): int
        {
            return $this->careerId;
        }
    
        public function setCareerId($careerId): void
        {
            $this->careerId = $careerId;
        }

        public function getCompanyId(): int
        {
            return $this->companyId;
        }
    
        public function setCompanyId($companyId): void
        {
            $this->companyId = $companyId;
        }

        public function getName(): string
        {
            return $this->name;
        }

        public function setName($name): void
        {
            $this->name = $name;
        }
        
        public function getDescription(): string
        {
            return $this->description;
        }

        public function setDescription($description): void
        {
            $this->description = $description;
        }

        public function isActive(): bool
        {
            return $this->active;
        }

        public function setActive($active): void
        {
            $this->active = $active;
        }
    }
?>