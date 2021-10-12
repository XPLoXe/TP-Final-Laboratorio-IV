<?php
    namespace Controllers;

    use DAO\PasswordDAO;
    use DAO\StudentDAO;
    use Models\Student;

    class LoginController
    {
        public function Login($email, $password)
        {
            $parameters = array();
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $parameters = $_POST;
                $email = $_POST["email"];
                $password = $_POST["password"];

                //loading students
                $studentsDAO = new StudentDAO();
                $studentsList = array();
                $studentsList = $studentsDAO->GetAll();
                $student = new Student();
                $student = $studentsDAO->getStudentByEmail($email);

                //loading passwords
                $passwordDAO = new PasswordDAO();
                $passwordList = array();
                $passwordList = $passwordDAO->GetAll();

                if (($email == "admin@admin.com") && ($password == "12345")) {
                    $_SESSION["isAdmin"] = true;
                    require_once(VIEWS_PATH."home.php"); //admin page redirect
                }

                if (!is_null($student)) {
                    
                    if ($passwordDAO->CheckUser($student->getStudentID(), $password)) {
                        $_SESSION["loggedUser"] = $student;
                        $_SESSION["isAdmin"] = false;
                        require_once(VIEWS_PATH."home.php"); //regular user redirect
                    }
                    else
                    {
                        echo "<script> if(confirm('Email or Password Incorrect, please try again'));";
                        echo "</script>";
                        require_once(VIEWS_PATH."index.php");
                    }
                }
                else
                {
                    echo "<script> if(confirm('Email not found'));";
                    echo "</script>";
                    require_once(VIEWS_PATH."index.php");
                }
            }
            else
            {
                header("location:index.php");
            }
        }


        public function Logout()
        {
            $_SESSION = array(); //Clean every variable set in $_SESSION (session_destroy() does not clean them)
            session_destroy();
            require_once(VIEWS_PATH."index.php");
        }
    }
?>