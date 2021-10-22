<?php

namespace Models;

use Models\Administrator as Administrator;

class Administrator extends Person{

    private int $adminId;
    private string $password; // We have to see the name of the atribute password in the DB

    public function getAdminId()
    {
        return $this->adminId;
    }

    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}



?>