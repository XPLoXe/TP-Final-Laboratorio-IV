<?php
namespace DAO;

use \Exception as Exception;
use Interfaces\IStudentDAO as IStudentDAO;
use Models\Student as Student;
use DAO\Connection as Connection;

class StudentDAO
{
    private $connection;
    private $tableName = "Students";


    public function GetAll(): array
    {
        $this->RetrieveData();
        
        return $this->studentList;
    }


    private function getStudentsFromApi(): string
    {
        $apiStudent = curl_init(API_URL . "Student");

        curl_setopt($apiStudent, CURLOPT_HTTPHEADER, array('x-api-key:' . API_KEY));
        curl_setopt($apiStudent, CURLOPT_RETURNTRANSFER, true);

        $dataAPI = curl_exec($apiStudent);

        return $dataAPI;
    }


    public function getStudentByEmail($email): Student
    {
        $this->RetrieveData();

        foreach ($this->studentList as $student) 
        {
            if ($student->getEmail() == $email)
                return $student;
        }

        return null;
    }


    public function getActiveStudents(): array
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


    public function getStudentById($id): Student
    {
        $this->RetrieveData();

        foreach ($this->studentList as $student) 
        {
            if ($student->getStudentId() == $id) {
                return $student;
            }

        }

        return null;
    }


    private function RetrieveData(): void // TODO: add $msg for situation where it can't retrieve students from API
    {
        $this->studentList = array();

        $dataAPI = $this->getStudentsFromApi();

        if ($arrayToDecode = json_decode($dataAPI, true))
        {
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
                    $student->setBirthDate($valuesArray["birthDate"]);
                    $student->setEmail($valuesArray["email"]);
                    $student->setPhoneNumber($valuesArray["phoneNumber"]);
                    $student->setActive($valuesArray["active"]);

                    array_push($this->studentList, $student);
                }
                
            }
        }
    }
}
