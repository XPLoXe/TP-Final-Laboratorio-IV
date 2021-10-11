<?php
    namespace Interfaces;

    use Models\JobPosition as JobPosition;

    interface IJobPositionDAO
    {
        //function Add(JobPositiont $jobPosition);
        function GetAll();
    }
?>