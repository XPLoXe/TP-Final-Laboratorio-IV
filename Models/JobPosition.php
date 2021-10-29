<?php
    namespace Models;

    class JobPosition
    {
        private int $jobPositionId;
        private int $careerId;
        private string $description;
        
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
        
        public function getDescription(): string
        {
            return $this->description;
        }

        public function setDescription($description): void
        {
            $this->description = $description;
        }

    }
?>