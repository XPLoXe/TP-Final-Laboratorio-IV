<?php
    namespace DAO;

    use DAO\Connection;
    use Interfaces\IUserRoleDAO as IUserRoleDAO;
    use Models\UserRole;
    use Exception;

    class userRoleDAO implements IUserRoleDAO
    {
        private $connection;
        private $tableName = "UserRoles";


        public function GetAll(): array
        {
            try
            {
                $userRoleList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {
                    $userRole = new UserRole($row["user_role_id"]);
                    $userRole->setDescription($row["description"]);
                    $userRole->isActive($row["active"]);
                    
                    array_push($userRoleList, $userRole);
                }
                return $userRoleList;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
            return null;
        }


        public function GetIdByDescription(string $description): int
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE description='".$description."'";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                $result = (int) $resultSet[0]['user_role_id'];
                
                return $result;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function GetUserRoleById(int $userRoleId): UserRole
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName.' WHERE user_role_id = :user_role_id AND active = :active ;';

                $parameters['user_role_id'] = $userRoleId;
                $parameters['active'] = true;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);
                
                $userRole = new UserRole($userRoleId);
                $userRole->setDescription($resultSet[0]['description']);
                $userRole->setActive($resultSet[0]['active']);

                return $userRole;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function GetDescriptionById(int $userRoleId): string
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {
                    if ($row["user_role_id"] == $userRoleId)
                        return $row["description"];
                }
                return null;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }
    }