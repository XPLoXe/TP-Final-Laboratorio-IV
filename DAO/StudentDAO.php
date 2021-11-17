<?php
    namespace DAO;

    use DAO\Connection as Connection;
    use Interfaces\IStudentDAO as IStudentDAO;
    use Models\Student as Student;
    use DAO\UserDAO as UserDAO;
    use Models\User as User;
    use DateTime;
    use Exception;

    class StudentDAO
    {
        private $connection;
        private $tableName = "Students";
        private $studentList;
        private $userDAO;

        public function __construct()
        {
            $this->userDAO = new UserDAO();
        }

        public function Add(Student $student)
        {
            try
            {
                $query = "INSERT INTO ".$this->tableName." (user_student_id, api_student_id, career_id, first_name, last_name, birth_date, phone_number, api_active) VALUES (:user_student_id, :api_student_id, :career_id, :first_name, :last_name, :birth_date, :phone_number, :api_active);";

                $this->userDAO->Add($student->getUser());//pasar password en el controller

                $parameters["user_student_id"] = $this->userDAO->GetLastId();

                $parameters["api_student_id"] = $student->getApiId();
                $parameters["career_id"] = $student->getCareerId();
                $parameters["first_name"] = $student->getFirstName();
                $parameters["last_name"] = $student->getLastName();
                $parameters["birth_date"] = $student->getBirthDay();
                $parameters["phone_number"] = $student->getPhoneNumber();
                $parameters["api_active"] = $student->isApiActive();
                
                $this->connection = Connection::GetInstance();
    
                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        //la llamo luego de saber q el usuario logeado es un estudiante
        public function updateDBStudentfromAPI($email)
        {
            //array = getallfromdb
            //array2 = UpdateStudentsFromAPI

            //itero y si son diferentes, los actualizo
            //los alumnos no se eliminan en la api, sino q su active es false

            //pensandolo bien para q quiero actualizar todos los estudiantes
            //solo quiero actualizar 1 solo, q es el q se esta logeando

            //puedo poner q si el email es null actualice todos los estdiantes
            //y si no es null actualizo solo ese mismo
        }

        public function GetAll(): array
        {
            try
            {
                $userStudentList = $this->userDAO->GetAll(ROLE_STUDENT);
                $this->UpdateStudentsFromAPI();

                $studentList = array();

                $query = 'SELECT * FROM '.$this->tableName.';';

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {
                    $user = $this->userDAO->GetSpecificUser($userStudentList,$row["user_student_id"]);

                    $studentAPI = $this->GetAPIStudentById($row["api_student_id"]);

                    $student = new Student();

                    $student->setStudentId($user->getUserId());
                    $student->setEmail($user->getEmail());
                    $student->setPassword($user->getPassword());
                    $student->setUserRole($user->getUserRole());
                    $student->setActive($user->getActive());

                    $student->setFirstName($row["first_name"]);
                    $student->setLastName($row["last_name"]);
                    $student->setApiId($row["api_student_id"]);
                    $student->setCareerId($row["career_id"]);
                    $student->setBirthDay($row["birth_date"]);
                    $student->setPhoneNumber($row["phone_number"]);
                    $student->setApiActive($row['api_active']);
                    //BD : API_ACTIVE (sobra)
                    /* Sobra porq siempre este dato lo tengo actualizar al momento de ingresar sesion
                    de las 2 formas tengo q pegarle a la api si o si
                    si    lo guardo en la BD, cuando lo quiero usar tengo q actualizarlo pegandole a la api
                    si no lo guardo en la BD, tengo q ir a la API a agarrarlo */
                    //PHP : FileNumber (falta agregar)
                    //PHP : DNI (falta agregar)
                    //PHP : GENDER (falta agregar)

                    /* Guardaria solo en la base de datos en la tabla Student (con respecto a datos de la api) el api_student_id */
                    $student->setFileNumber($studentAPI->getFileNumber());
                    $student->setDni($studentAPI->getDni());
                    $student->setGender($studentAPI->getGender());

                    array_push($studentList,$student);
                }
                
                return $studentList;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }

        public function GetAPIStudentById(int $id)//GetAll, solo itera studentList
        {

            foreach ($this->studentList as $student) 
            {
                if ($student->getApiId() == $id)
                    return $student;
            }

            return null;
        }

        public function GetStudentByEmail(string $email)//LoginController
        {
            $studentList = $this->GetAll();//Base de datos

            foreach ($studentList as $student) 
            {
                if ($student->getEmail() == $email)
                    return $student;
            }

            return null;
        }

        public function GetStudentByUser(User $user): Student
        {
            try
            {
                $userStudent= $this->userDAO->GetUserById($user->getUserId());

                $this->UpdateStudentsFromAPI();//actualizo la api

                $query = 'SELECT * FROM '.$this->tableName.' WHERE user_student_id = :user_student_id;';

                $parameters['user_student_id'] = $userStudent->getUserId();

                $this->connection = Connection::GetInstance();

                $row = $this->connection->Execute($query, $parameters)[0];
                
                if (!empty($row))
                {
                    $studentAPI = $this->GetAPIStudentById($row["api_student_id"]);

                    $student = new Student();

                    $student->setStudentId($userStudent->getUserId());
                    $student->setEmail($userStudent->getEmail());
                    $student->setPassword($userStudent->getPassword());
                    $student->setUserRole($userStudent->getUserRole());
                    $student->setActive($userStudent->isActive());

                    $student->setFirstName($row["first_name"]);
                    $student->setLastName($row["last_name"]);
                    $student->setApiId($row["api_student_id"]);
                    $student->setCareerId($row["career_id"]);
                    $student->setBirthDate(new DateTime($row["birth_date"]));
                    $student->setPhoneNumber($row["phone_number"]);
                    $student->setApiActive($row["api_active"]);

                    $student->setFileNumber($studentAPI->getFileNumber());
                    $student->setDni($studentAPI->getDni());
                    $student->setGender($studentAPI->getGender());
                }
                
                return $student;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        // public function GetStudentById(int $id)//API
        // {
        //     $this->RetrieveData();

        //     foreach ($this->studentList as $student) 
        //     {
        //         if ($student->getStudentId() == $id)
        //             return $student;
        //     }

        //     return null;
        // }

        // public function GetStudentByLastName(string $lastName)//API
        // {
        //     $this->RetrieveData();

        //     foreach ($this->studentList as $student) 
        //     {
        //         if ($student->getLastName() == $lastName)
        //             return $student;
        //     }

        //     return null;
        // }

        // public function GetCareerIdByStudentId(string $studentId)//API
        // {
        //     $this->RetrieveData();

        //     foreach ($this->studentList as $student) 
        //     {
        //         if ($student->getStudentId() == $studentId)
        //             return $student->getCareerId();
        //     }

        //     return null;  
        // }

        private function GetStudentsFromApi(): string
        {
            $apiStudent = curl_init(API_URL . "Student");

            curl_setopt($apiStudent, CURLOPT_HTTPHEADER, array('x-api-key:' . API_KEY));
            curl_setopt($apiStudent, CURLOPT_RETURNTRANSFER, true);

            $dataAPI = curl_exec($apiStudent);

            return $dataAPI;
        }

        //este getall solo lo uso para agregar al estudiante a la base de datos y nada mas
        private function UpdateStudentsFromAPI(): void // TODO: add $msg for situation where it can't retrieve students from API
        {
            $this->studentList = array();

            $dataAPI = $this->GetStudentsFromApi();

            if ($arrayToDecode = json_decode($dataAPI, true))
            {
                foreach ($arrayToDecode as $valuesArray)
                {
                    $student = new Student();
                    $student->setApiId($valuesArray["studentId"]);
                    $student->setCareerId($valuesArray["careerId"]);

                    $student->setFirstName($valuesArray["firstName"]);
                    $student->setLastName($valuesArray["lastName"]);
                    $student->setDni($valuesArray["dni"]);
                    $student->setFileNumber($valuesArray["fileNumber"]);
                    $student->setGender($valuesArray["gender"]);
                    $student->setBirthDate(new DateTime($valuesArray["birthDate"]));
                    $student->setEmail($valuesArray["email"]);
                    $student->setPhoneNumber($valuesArray["phoneNumber"]);
                    $student->setApiActive($valuesArray["active"]);

                    array_push($this->studentList, $student);
                }
            }
        }
    }