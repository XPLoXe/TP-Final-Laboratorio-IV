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
        
        
        try
        {
            $query = "SELECT email FROM ". $this->tableName . " WHERE email = '" . $email . "';";
            $this->connection = Connection::GetInstance();
            $PDO = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NAME, DB_USER,DB_PASS);
            $statement = $PDO->prepare($query);
            $parameters = array(
                'email' => $email
            );
            $statement->Execute($parameters);
            $user_email = $statement->fetch();

            /* $parameters = $this->connection->Execute($query); */
            
            die(var_dump($user_email["email"]));
            if (strcmp($email, $parameters["email"]) == 0) 
            {
                return true;
            }
            else
            {
                return false;
            }
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
