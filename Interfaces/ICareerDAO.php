<?php
    namespace Interfaces;

    use Models\Career as Career;

    interface ICareerDAO
    {
        function Add(Career $career);
        function GetAll();
    }