<?php
    namespace Controllers;

    use DAO\StudentDAO as StudentDAO;
    use Models\Student as Student;

    use Utils\Utils as Utils;

    class StudentController
    {
        private $studentDAO;

        public function __construct()
        {
            $this->studentDAO = new StudentDAO();
        }

        public function ShowAddView()
        {
            Utils::checkAdmin();

            require_once(VIEWS_PATH."student-add.php");
        }

        public function ShowListView()
        {
            Utils::checkUserLoggedIn();

            $studentList = $this->studentDAO->GetAll();

            require_once(VIEWS_PATH."student-list.php");
        }

        public function getStudentByEmail($email)
        {
            return $this->studentDAO->getStudentByEmail($email);
        }

        public function Add($fileNumber, $firstName, $lastName)
        {
            Utils::checkAdmin();

            $student = new Student();
            $student->setFileNumber($fileNumber);
            $student->setFirstName($firstName);
            $student->setLastName($lastName);

            $this->studentDAO->Add($student);

            $this->ShowAddView();
        }
    }
?>