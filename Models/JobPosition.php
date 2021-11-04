<?php
    namespace Models;

    class JobPosition
    {
        private int $jobPositionId;
        private int $careerId;
        private string $description;
        private int $active;
        

       /*  public function __construct($id)
        {
            $this->jobPositionId = $id;
        } */

        public function __construct()
        {
            
        }


        public function getJobPositionId(): int
        {
            return $this->jobPositionId;
        }
    

        public function setJobPositionId(int $jobPositionId): void
        {
            $this->jobPositionId = $jobPositionId;
        }
        

        public function getCareerId(): int
        {
            return $this->careerId;
        }
    

        public function setCareerId(int $careerId): void
        {
            $this->careerId = $careerId;
        }
        

        public function getDescription(): string
        {
            return $this->description;
        }


        public function setDescription(string $description): void
        {
            $this->description = $description;
        }

    }