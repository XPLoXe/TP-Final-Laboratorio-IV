<?php
    namespace Interfaces;

    use Models\UserRole as UserRole;
    use DAO\Connection as Connection;

    interface IUserRoleDAO
    {
        function GetAll();
    }
?>