<?php
    namespace Interfaces;

    use Models\JobPosition as JobPosition;

    interface IJobPositionDAO
    {
        function Add(JobPosition $jobPosition);
        function GetAll();
    }
?>