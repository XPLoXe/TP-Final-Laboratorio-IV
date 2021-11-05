<?php
    namespace Interfaces;

    use Models\JobPosition as JobPosition;

    interface IJobPositionDAO
    {
        function GetAll();
    }