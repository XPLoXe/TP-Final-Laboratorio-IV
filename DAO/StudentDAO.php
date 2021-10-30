<?php
namespace DAO;

use \Exception as Exception;
use Interfaces\IStudentDAO as IStudentDAO;
use Models\Student as Student;
use DAO\Connection as Connection;

class StudentDAO implements IStudentDAO
{
    private $connection;
    private $tableName = "students";

    public function Add(Student $student)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (studentId, firstName, lastName, dni, birthDate, email, phoneNumber, active, password) VALUES (:studentId, :firstName, :lastName, :dni, :birthDate, :email, :phoneNumber, :active, :password);";
            
            $parameters["studentId"] = $student->getFileNumber();
            $parameters["firstName"] = $student->getFirstName();
            $parameters["lastName"] = $student->getLastName();
            $parameters["dni"] = $student->getDni();
            $parameters["birthDate"] = $student->getBirthDay();
            $parameters["email"] = $student->getEmail();
            $parameters["phoneNumber"] = $student->getPhoneNumber();
            $parameters["active"] = $student->isActive();
            $parameters["password"] = $student->getPassword(); // We have to see the name of the atribute password in the DB

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }


    public function GetAll()
    {
        try
        {
            $studentList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);
            
            foreach ($resultSet as $row)
            {                
                $student = new Student();
                $student->setFileNumber($row["studentId"]);
                $student->setFirstName($row["firstName"]);
                $student->setLastName($row["lastName"]);
                $student->setDni($row["dni"]);
                $student->setBirthDay($row["birthDate"]);
                $student->setEmail($row["email"]);
                $student->setPhoneNumber($row["phoneNumber"]);
                $student->setActive($row["active"]);
                $student->setPassword($row["password"]); // We have to see the name of the atribute password in the DB

                array_push($studentList, $student);
            }

            return $studentList;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }


    private function getStudentsFromApi()
    {
        $apiStudent = curl_init(API_URL . "Student");

        curl_setopt($apiStudent, CURLOPT_HTTPHEADER, array('x-api-key:' . API_KEY));
        curl_setopt($apiStudent, CURLOPT_RETURNTRANSFER, true);

        $dataAPI = curl_exec($apiStudent);

        return $dataAPI;
    }


    public function getStudentByEmail($email)
    {
        $this->RetrieveData();

        foreach ($this->studentList as $student) 
        {
            if ($student->getEmail() == $email)
                return $student;
        }

        return null;
    }


    public function getActiveStudents()
    {

        $this->RetrieveData();

        $activeStudents = array();

        foreach ($this->studentList as $student) 
        {
            if ($student->isActive())
                array_push($activeStudents, $student);
        }

        return $activeStudents;
    }


    public function getStudentById($id){

        $this->RetrieveData();

        foreach ($this->studentList as $student) 
        {
            if ($student->getStudentId() == $id) {
                return $student;
            }

        }

        return null;

    }


    private function RetrieveData()
    {
        $this->studentList = array();

        $dataAPI = $this->getStudentsFromApi();

        $arrayToDecode = json_decode($dataAPI, true);

        foreach ($arrayToDecode as $valuesArray) 
        {
            if ($valuesArray["active"]) {
                $student = new Student();
                $student->setStudentId($valuesArray["studentId"]);
                $student->setCareerId($valuesArray["careerId"]);

                $student->setFirstName($valuesArray["firstName"]);
                $student->setLastName($valuesArray["lastName"]);
                $student->setDni($valuesArray["dni"]);
                $student->setFileNumber($valuesArray["fileNumber"]);
                $student->setGender($valuesArray["gender"]);
                $student->setBirthDay($valuesArray["birthDate"]);
                $student->setEmail($valuesArray["email"]);
                $student->setPhoneNumber($valuesArray["phoneNumber"]);
                $student->setActive($valuesArray["active"]);

                array_push($this->studentList, $student);
            }
            
        }
    }
}
