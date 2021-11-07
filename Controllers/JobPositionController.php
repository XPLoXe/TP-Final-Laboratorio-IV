<?php
    namespace Controllers;

    use DAO\JobPositionDAO as JobPositionDAO;
    use Models\JobPosition as JobPosition;
    use Utils\Utils as Utils;

    class JobPositionController
    {
        private $jobPositionDAO;


        public function __construct()
        {
            $this->jobPositionDAO = new JobPositionDAO();
        }


        public function GetAll()
        {
            $jobPositionList = $this->jobPositionDAO->GetAll();

            return $jobPositionList;
        }


        public function GetJobPositionById(int $jobPositionId): JobPosition
        {
            $jobPositionList = $this->jobPositionDAO->GetAll();
            
            foreach ($jobPositionList as $jobPosition)
            {
                if ($jobPosition->getJobPositionId() == $jobPositionId)
                    return $jobPosition;
            }

            return null;
        }
    

        public function GetJobPositionByName(string $name): JobPosition
        {
            return $this->jobPositionDAO->GetJobPositionByName($name);
        }
    }