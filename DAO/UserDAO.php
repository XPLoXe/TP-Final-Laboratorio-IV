<?php
namespace DAO;

use Exception as Exception;
use Interfaces\IUserDAO as IUserDAO;
use Models\User as User;
use DAO\Connection as Connection;
use PDO;

class UserDAO implements IUserDAO
{
    private $connection;
    private $tableName = "Users";

    public function Add(User $user)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (email, user_password, user_role_id, active) VALUES (:email, :user_password, :user_role_id, :active);";

            $parameters["email"] = $user->getEmail();
            $parameters["user_password"] = $user->getPassword();
            $parameters["user_role_id"] = $user->getUserRole()->getUserRoleId();
            $parameters["active"] = $user->isActive();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }

    public function VerifyEmailDataBase($email)
    {
        $data = array();
        try
        {
            $query = "SELECT * FROM ". $this->tableName . " WHERE email = :email;";
            $parameters['email'] = $email;
            $this->connection = Connection::GetInstance();
            $data = $this->connection->Execute($query, $parameters);
            if (array_key_exists(0, $data))                         
            {   
                if (strcmp($email, $data[0]["email"]) == 0)     //return true if the email is already on data base
                {
                    return true;
                }
            }
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
        return false;
    }


    public function GetAll()
    {
        try
        {
            $userList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);
            
            foreach ($resultSet as $row)
            {                
                $user = new User();
                $student->setEmail($row["email"]);
                $student->setPassword($row["password"]);
                $student->setActive($row["active"]);

                array_push($userList, $user);
            }

            return $userList;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }


    private function RetrieveData()
    {
        // $this->studentList = array();

        // $dataAPI = $this->getUsers();

        //$array = levantodelabasededatos

        // foreach ($array as $valuesArray) 
        // {
        //     $user = new User();

        //     $student->setEmail($valuesArray["email"]);
        //     $student->setActive($valuesArray["active"]);

        //     array_push($this->studentList, $student);
        // }
    }
}
