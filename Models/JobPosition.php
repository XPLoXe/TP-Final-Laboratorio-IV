<?php
    namespace Models;

    class JobPosition
    {
        private int $jobPositionId;
        private int $careerId;
        private string $description;
        

        public function __construct($id)
        {
            $this->jobPositionId = $id;
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
    
<<<<<<< HEAD

        public function setCareerId(int $careerId): void
=======
        public function setCareerId($careerId): void
>>>>>>> e4fb5105b8f0e4cd415b8db4d6237521e635d484
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

<<<<<<< HEAD

        public function isActive(): bool
        {
            return $this->active;
        }


        public function setActive(bool $active): void
        {
            $this->active = $active;
        }
    }
=======
    }
?>
>>>>>>> e4fb5105b8f0e4cd415b8db4d6237521e635d484
