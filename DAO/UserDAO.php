<?php
namespace DAO;

use Exception as Exception;
use Interfaces\IUserDAO as IUserDAO;
use Models\User as User;
use DAO\Connection as Connection;
use Models\UserRole as UserRole;

class UserDAO implements IUserDAO
{
    private $connection;
    private $tableName = "Users";

    public function Add(User $user)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (email, user_password, user_role_id, api_user_id, first_name, last_name) 
            VALUES (:email, :user_password, :user_role_id, :api_user_id, :first_name, :last_name);";

            $parameters["email"] = $user->getEmail();
            $parameters["user_password"] = $user->getPassword();
            $parameters["user_role_id"] = $user->getUserRole()->getUserRoleId();
            $parameters["api_user_id"] = $user->getApiUserId();
            $parameters["first_name"] = $user->getFirstName();
            $parameters["last_name"] = $user->getLastName();

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
                $user->setEmail($row["email"]);
                $user->setPassword($row["user_password"]);
                $user->setFirstName($row["first_name"]);
                $user->setLastName($row["last_name"]);
                $user->setUserRole(new UserRole($row["user_role_id"]));
                $user->setApiUserId($row["api_user_id"]);
                $user->setActive($row["active"]);

                array_push($userList, $user);
            }

            return $userList;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }

    public function getUserByEmail(string $email): User
    {
        try
        {
            $userList = array();

            $query = "SELECT * FROM ".$this->tableName.' WHERE email="'.$email.'"';

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);
                                 
            $user = new User();
            $user->setEmail($resultSet[0]["email"]);
            $user->setPassword($resultSet[0]["user_password"]);
            $user->setFirstName($resultSet[0]["first_name"]);
            $user->setLastName($resultSet[0]["last_name"]);
            $user->setUserRole(new UserRole($resultSet[0]["user_role_id"]));
            $user->setApiUserId($resultSet[0]["api_user_id"]);
            $user->setActive($resultSet[0]["active"]);

            return $user;
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
