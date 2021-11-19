<?php
    namespace Controllers;

    use Controllers\JobOfferController as JobOfferController;
    use DAO\CareerDAO as CareerDAO;
    use DAO\StudentDAO as StudentDAO;
    use DAO\UserDAO;
    use DAO\userRoleDAO;
    use DateTime;
    use Models\Student as Student;
    use Models\User as User;
    use Utils\Utils as Utils;

    class StudentController
    {
        private $studentDAO;
        private $careerDAO;
        private $userRoleDAO;
        private $userDAO;


        public function __construct()
        {
            $this->studentDAO = new StudentDAO();
            $this->careerDAO = new CareerDAO;
            $this->userRoleDAO = new userRoleDAO();
            $this->userDAO = new UserDAO;
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
                if ($student->isApiActive())
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

            $studentList = $this->studentDAO->GetAllFromAPI();

            require_once(VIEWS_PATH."student-list.php");
        }


        public function ShowInfoView(array $parameters): void
        {
            Utils::checkUserLoggedIn();
            
            
            $student = $this->studentDAO->GetStudentByUserId($parameters["studentInfo"]);
    
            $career = $this->careerDAO->GetCareerById($student->getCareerId());
            $jobOfferController = new JobOfferController();
            
            $applications = $jobOfferController->GetStudentApplications($student->getUserId()); 
        

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
                        $studentList = $this->studentDAO->GetAllFromAPI();
                    } 
                    else
                        array_push($studentList, $student);

                    require_once(VIEWS_PATH."student-list.php");
                }
            }
        }


        public function GetStudentByUserId(int $userId): Student
        {
            return $this->studentDAO->GetStudentByUserId($userId);
        }


        public function GetApplicants(int $jobOfferId): array
        {
            return $this->studentDAO->GetApplicants($jobOfferId);
        }

        public function RegisterNewStudent(array $parameters):void
        {
            if ($this->VerifyPassword($parameters["password"], $parameters["password_confirmation"]))
            {
                $student = $this->GetStudentByEmail($parameters["email"]);
                if(!is_null($student))
                {
                    $student->setPassword($parameters["password"]);
                    $student->setUserRole($this->userRoleDAO->GetUserRoleByDescription(ROLE_STUDENT));
                    $student->setActive(true);
                    $this->Add($student);
                }
                else
                {
                    $message = ERROR_VERIFY_EMAIL ;
                    require_once(VIEWS_PATH."login.php");
                }
                
            }
            else
            {
                $message = ERROR_VERIFY_PASSWORD ;
                require_once(VIEWS_PATH."login.php");
            }
            
        }

        public function Add(Student $student)
        {
            
            if ($this->userDAO->IsEmailInDB($student->getEmail()) || !$this->IsStudentActiveInUniversity($student->getEmail()))
            {   
                $message = ERROR_STUDENT_DUPLICATE ;
                require_once(VIEWS_PATH."login.php");
            }
            else
            {
                $this->studentDAO->Add($student);
                $message = SIGNUP_SUCCESS;
                require_once(VIEWS_PATH."login.php");
            }
            
            
        }

        public function VerifyPassword(string $password, string $passwordConfirmation): bool
        {
            if (strcmp($password, $passwordConfirmation) == 0)
                return true;
            else
            {
                $this->message = ERROR_VERIFY_PASSWORD;
                return false;
            }
        }
    }
