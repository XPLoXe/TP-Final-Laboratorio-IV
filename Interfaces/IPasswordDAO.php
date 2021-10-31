<?php
    namespace Interfaces;

    interface IPasswordDAO
    {
        //function Add(Career $career);
        public function GetAll();
        public function CheckUser($id, $password);

    }