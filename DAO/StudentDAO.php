<?php
namespace DAO;

use Interfaces\IStudentDAO as IStudentDAO;
use Models\Student as Student;

class StudentDAO implements IStudentDAO
{
    private $studentList = array();

    public function GetAll()
    {
        $this->RetrieveData();

        return $this->studentList;
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

        foreach ($this->studentList as $student) {

            if ($student->getEmail() == $email) {
                return $student;
            }

        }

        return null;
    }

    public function getActiveStudents()
    {

        $this->RetrieveData();

        $activeStudents = array();

        foreach ($this->studentList as $student) {

            if ($student->getActive()) {
                array_push($activeStudents, $student);
            }

        }

        return $activeStudents;
    }

    public function getStudentById($id){

        $this->RetrieveData();

        foreach ($this->studentList as $student) {

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

        foreach ($arrayToDecode as $valuesArray) {

            $student = new Student(); 

            $student->setStudentId($valuesArray["studentId"]);
            $student->setCareerId($valuesArray["carrerId"]);

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
