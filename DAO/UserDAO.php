<?php
    namespace DAO;

    use DAO\UserRoleDAO as UserRoleDAO;
    use DAO\Connection as Connection;
    use Interfaces\IUserDAO as IUserDAO;
    use Models\User as User;
    use Models\UserRole as UserRole;
    use Exception;

    class UserDAO implements IUserDAO
    {
        private $connection;
        private $tableName = "Users";
        private $userRoleDAO;


        public function __construct()
        {
            $this->userRoleDAO = new UserRoleDAO;
        }

        
        public function Add(User $user): void
        {
            try
            {
                $query = "INSERT INTO ".$this->tableName." (email, user_password, user_role_id) 
                VALUES (:email, :user_password, :user_role_id);";

                $parameters["email"] = $user->getEmail();
                $parameters["user_password"] = $user->getPassword();
                $parameters["user_role_id"] = $user->getUserRoleId();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function Delete(int $userId): void
        {
            try
            {
                $query = "UPDATE ".$this->tableName." SET active = false WHERE user_id = :user_id ;";

                $parameters['user_id'] = $userId;

                $this->connection = Connection::GetInstance();

                $rowCount = $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function Edit(User $user): void
        {
            try
            {
                $query =   "UPDATE ".$this->tableName." SET email = :email , user_password = :user_password , user_role_id = :user_role_id WHERE user_id = :user_id ;";

                $parameters['user_id'] = $user->getUserId();
                $parameters['email'] = $user->getEmail();
                $parameters['user_password'] = $user->getPassword();
                $parameters['user_role_id'] = $user->getUserRoleId();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function IsEmailInDataBase(string $email): bool
        {
            try
            {
                $query = "SELECT * FROM ". $this->tableName . " WHERE email = :email;";

                $parameters['email'] = $email;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);

                if (!empty($resultSet))                         
                {   
                    if (strcmp($email, $resultSet[0]["email"]) == 0)
                        return true;
                }
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
            return false;
        }


        public function GetAll(): array
        {
            try
            {
                $userList = array();

                $query = "SELECT * FROM ".$this->tableName." u INNER JOIN UserRoles ur ON u.user_role_id = ur.user_role_id WHERE u.active = :active ;";

                $parameters['active'] = true;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);
                
                foreach ($resultSet as $row)
                {
                    $user = new User();
                    $user->setUserId($row["user_id"]);
                    $user->setEmail($row["email"]);
                    $user->setPassword($row["user_password"]);

                    $userRole = new UserRole($row['user_role_id']);
                    $userRole->setDescription($row['description']);
                    $user->setUserRole($userRole);

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


        public function GetUserByEmail(string $email): User
        {
            try
            {
                $userList = array();

                $query = "SELECT * FROM ".$this->tableName.' WHERE email=:email ';

                $parameters["email"] = $email;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query,$parameters);

                $user = new User();
                $user->setUserId($resultSet[0]["user_id"]);
                $user->setEmail($resultSet[0]["email"]);
                $user->setPassword($resultSet[0]["user_password"]);
                $user->setUserRole($this->userRoleDAO->GetUserRoleById($resultSet[0]["user_role_id"])); // TODO: use INNER JOIN
                $user->setActive($resultSet[0]["active"]);

                return $user;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function GetUserById(int $userId): User
        {
            try
            {
                $userList = array();

                $query = "SELECT * FROM ".$this->tableName." WHERE user_id = :user_id ;";

                $parameters['user_id'] = $userId;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);

                $user = new User();
                $user->setUserId($resultSet[0]["user_id"]);
                $user->setEmail($resultSet[0]["email"]);
                $user->setPassword($resultSet[0]["user_password"]);
                $user->setUserRole($this->userRoleDAO->GetUserRoleById($resultSet[0]["user_role_id"])); // TODO: use INNER JOIN
                $user->setActive($resultSet[0]["active"]);
                
                return $user;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }
    }