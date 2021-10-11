<?php
    namespace Controllers;

    use DAO\StudentDAO as StudentDAO;
    use Models\Student as Student;

    class StudentController
    {
        private $studentDAO;

        public function __construct()
        {
            $this->studentDAO = new StudentDAO();
        }

        public function ShowAddView()
        {
            require_once(VIEWS_PATH."student-add.php");
        }

        public function ShowListView()
        {
            $studentList = $this->studentDAO->GetAll();

            require_once(VIEWS_PATH."student-list.php");
        }

        public function Add($fileNumber, $firstName, $lastName)
        {
            $student = new Student();
            $student->setFileNumber($fileNumber);
            $student->setFirstName($firstName);
            $student->setLastName($lastName);

            $this->studentDAO->Add($student);

            $this->ShowAddView();
        }
    }
?>