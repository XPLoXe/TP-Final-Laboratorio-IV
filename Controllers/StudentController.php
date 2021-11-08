<?php
    namespace Controllers;

    use Controllers\JobOfferController as JobOfferController;
    use DAO\CareerDAO;
    use DAO\StudentDAO as StudentDAO;
    use Models\Student as Student;
    use Utils\Utils as Utils;

    class StudentController
    {
        private $studentDAO;
        private $careerDAO;

        public function __construct()
        {
            $this->studentDAO = new StudentDAO();
            $this->careerDAO = new CareerDAO;
            
        }


        public function GetStudentByEmail(string $email)
        {
            return $this->studentDAO->GetStudentByEmail($email);
        }


        public function GetStudentById(int $id)
        {
            return $this->studentDAO->GetStudentById($id);
        }


        public function IsStudentActiveInUniversity(string $email): bool
        {
            $student = $this->GetStudentByEmail($email);

            if (!is_null($student))
            {
                if ($student->isActive())
                    return true;
                else
                    return false;
            }
            else
                return false;
        }


        public function ShowListView(): void
        {
            Utils::checkUserLoggedIn();

            $studentList = $this->studentDAO->GetAll();

            require_once(VIEWS_PATH."student-list.php");
        }

        public function ShowInfoView(): void
        {
            Utils::checkUserLoggedIn();
            $student = $this->studentDAO->GetStudentByEmail($_SESSION["loggedUser"]->getEmail());
            $career = $this->careerDAO->GetCareerById($student->getCareerId());
            $jobOfferController = new JobOfferController();
            $jobOffer = $jobOfferController->GetJobOfferByUserId($_SESSION["loggedUser"]->getUserId());

            require_once(VIEWS_PATH."student-info.php");
        }


        public function FilterByLastName(array $parameters): void
        {
            Utils::checkUserLoggedIn();

            $studentList = array();

            if ($_SERVER['REQUEST_METHOD'] == "POST") 
            {
                if (empty($parameters["nameToFilter"])) 
                    $this->ShowListView();
                else
                {
                    $student  = $this->studentDAO->GetStudentByLastName($parameters["nameToFilter"]);

                    if (is_null($student))
                    {
                        $message = ERROR_STUDENT_FILTER;
                        $studentList = $this->studentDAO->GetAll();
                    } 
                    else
                        array_push($studentList, $student);

                    require_once(VIEWS_PATH."student-list.php");
                }
            }
        }
    }
