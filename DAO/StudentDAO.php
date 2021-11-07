<?php
    namespace DAO;

    use DAO\Connection as Connection;
    use Interfaces\IStudentDAO as IStudentDAO;
    use Models\Student as Student;
    use DateTime;
    use Exception;

    class StudentDAO
    {
        private $connection;
        private $tableName = "Students";


        public function GetAll(): array
        {
            $this->RetrieveData();
            
            return $this->studentList;
        }


        private function GetStudentsFromApi(): string
        {
            $apiStudent = curl_init(API_URL . "Student");

            curl_setopt($apiStudent, CURLOPT_HTTPHEADER, array('x-api-key:' . API_KEY));
            curl_setopt($apiStudent, CURLOPT_RETURNTRANSFER, true);

            $dataAPI = curl_exec($apiStudent);

            return $dataAPI;
        }


        public function GetStudentByEmail(string $email): Student
        {
            $this->RetrieveData();

            foreach ($this->studentList as $student) 
            {
                if ($student->getEmail() == $email)
                    return $student;
            }

            return null;
        }

        public function GetStudentByLastName(string $lastName): Student
        {
            $this->RetrieveData();

            foreach ($this->studentList as $student) 
            {
                if ($student->getLastName() == $lastName)
                    return $student;
            }

            return null;
        }

        public function GetCareerIdByStudentId(string $studentId): int
        {
            $this->RetrieveData();

            foreach ($this->studentList as $student) 
            {
                if ($student->getStudentId() == $studentId)
                    return $student->getCareerId();
            }

            return null;  
        }

        private function RetrieveData(): void // TODO: add $msg for situation where it can't retrieve students from API
        {
            $this->studentList = array();

            $dataAPI = $this->GetStudentsFromApi();

            if ($arrayToDecode = json_decode($dataAPI, true))
            {
                foreach ($arrayToDecode as $valuesArray)
                {
                    $student = new Student();
                    $student->setStudentId($valuesArray["studentId"]);
                    $student->setCareerId($valuesArray["careerId"]);

                    $student->setFirstName($valuesArray["firstName"]);
                    $student->setLastName($valuesArray["lastName"]);
                    $student->setDni($valuesArray["dni"]);
                    $student->setFileNumber($valuesArray["fileNumber"]);
                    $student->setGender($valuesArray["gender"]);
                    $student->setBirthDate(new DateTime($valuesArray["birthDate"]));
                    $student->setEmail($valuesArray["email"]);
                    $student->setPhoneNumber($valuesArray["phoneNumber"]);
                    $student->setActive($valuesArray["active"]);

                    array_push($this->studentList, $student);
                }
            }
        }
    }