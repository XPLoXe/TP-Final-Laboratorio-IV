<?php
    namespace Controllers;

    use Controllers\CompanyController as CompanyController;
    use Controllers\JobPositionController as JobPositionController;
    use Controllers\UserController as UserController;
    use DAO\CompanyDAO as CompanyDAO;
    use DAO\JobOfferDAO as JobOfferDAO;
    use DAO\JobPositionDAO as JobPositionDAO;
    use Models\Company as Company;
    use Models\JobOffer as JobOffer;
    use Models\JobPosition as JobPosition;
    use Utils\Utils as Utils;
    use DateTime;
    use FPDF;
    use tFPDF;

    class JobOfferController
    {
        private JobPositionController $jobPositionController;
        private StudentController $studentController;
        private UserController $userController;
        private CompanyDAO $companyDAO;
        private JobOfferDAO $jobOfferDAO;
        private JobPositionDAO $jobPositionDAO;


        public function __construct()
        {
            $this->jobPositionController = new JobPositionController;
            $this->studentController = new StudentController;
            $this->userController = new UserController;
            $this->jobOfferDAO = new JobOfferDAO;
            $this->jobPositionDAO = new JobPositionDAO;
            $this->companyDAO = new CompanyDAO();
        }


        public function Add(array $parameters)
        {
            
            
            $jobOffer = new JobOffer;
            $companyDAO = new CompanyDAO;
            $jobPositionDAO = new JobPositionDAO;

            
            $company = $companyDAO->GetCompanyById($parameters["companyId"]);
            $jobOffer->setCompany($company);
            
            $jobPosition = $jobPositionDAO->GetJobPositionById($parameters["jobPositionId"]);
            $jobOffer->setJobPosition($jobPosition);
        
            $jobOffer->setDescription($parameters["description"]);
            $jobOffer->setPublicationDate(new DateTime($parameters["publicationDate"]));
            $jobOffer->setExpirationDate(new DateTime($parameters["expirationDate"]));
            if(($parameters['flyer']['error']) == 0)
                $jobOffer->setFlyer(base64_encode(file_get_contents($parameters['flyer']["tmp_name"])));
            $this->jobOfferDAO->Add($jobOffer);

            if(Utils::isCompany())
                $this->ShowOwnJobOffersListView();

            $this->ShowListView();
        }


        public function Delete(array $parameters)
        {
            Utils::checkAdminOrCompany();

            //Al eliminar una JobOffer, deberiamos eliminar todas las postulaciones de la misma
            $this->jobOfferDAO->Delete($parameters['jobOfferId']);

            $this->ShowListView();
        }

        public function FilterByPosition($parameters)
        {
            Utils::checkUserLoggedIn();

            if ($_SERVER['REQUEST_METHOD'] == "POST") { 
                
                if (empty($parameters["nameToFilter"])) 
                {   
                    $this->ShowListView();
                } else
                {
                    $jobPositionList  = $this->jobPositionController->getJobPositionByName($parameters["nameToFilter"]);

                    $jobOfferList = $this->GetAll();

                    $jobOfferFiltered = array();

                    if (!empty($jobPositionList))
                    {
                        foreach ($jobPositionList as $jobPosition)
                        {
                            foreach ($jobOfferList as $jobOffer)
                            {
                                if ($jobPosition->getJobPositionId() == $jobOffer->getJobPositionId()) {
                                    array_push($jobOfferFiltered, $jobOffer);
                                }
                            }
                        }

                        $jobOfferList = $jobOfferFiltered;

                    } 
                    else
                    {
                        $msgErrorFilter = ERROR_JOBOFFER_FILTER; // TODO: move HTML code to view
                    } 

                    require_once(VIEWS_PATH."job-offer-list.php");
                }
            }
        }


        public function Edit(array $parameters)
        {
            Utils::checkAdminOrCompany();

            $jobOffer = new JobOffer;

            $jobOffer->setJobOfferId($parameters['jobOfferId']);
            $jobOffer->setJobPositionId($parameters['jobPositionId']);
            $jobOffer->setCompanyId($parameters['companyId']);      
            $jobOffer->setExpirationDate(new DateTime($parameters['expirationDate']));
            $jobOffer->setDescription($parameters['description']);
            if(!empty($parameters['flyer']['tmp_name']))
                $jobOffer->setFlyer($parameters['flyer']["tmp_name"]);
            else
            {
                $jobOffer->setFlyer("");
            }
            $this->jobOfferDAO->Edit($jobOffer);

            $jobOfferList = $this->GetAll();
            require_once(VIEWS_PATH."job-offer-list.php");
        }

        
        public function GetAll(): array
        {
            if (Utils::isStudent()) // TODO: filter more cases
                $jobOffers = $this->jobOfferDAO->GetAll(FILTER_STUDENT);
            else
                $jobOffers = $this->jobOfferDAO->GetAll(FILTER_ALL);
            return $jobOffers;
        }

        
        public function GetJobOfferById(int $jobOfferId): JobOffer
        {
            return $this->jobOfferDAO->GetJobOfferById($jobOfferId);
        }


        public function GetJobOfferByUserId(int $userId): JobOffer
        {
            return $this->jobOfferDAO->GetJobOfferByUserID($userId);
        }


        public function Apply(array $parameters): void
        {
            if (Utils::isStudent())
                $this->jobOfferDAO->Apply($parameters['jobOfferId'], $_SESSION["loggedUser"]->getUserId());

            $message = APPLY_SUCCESS;
            header("location:".FRONT_ROOT."Home/Index");
        }


        public function DeleteApplicant(array $parameters): void
        {

            Utils::checkAdminOrCompany();

            $userController = new UserController;

            $this->jobOfferDAO->DeleteApplication((int)$parameters["jobOfferId"], (int)$parameters["studentId"]);
            
            if (Utils::isAdmin()) 
            {
                $user = $userController->GetUserById((int)$parameters["studentId"]);
                $to_email = $user->getEmail();
                $subject = APPLY_DELETE_EMAIL_SUBJECT;
                $body = APPLY_DELETE_EMAIL;
                $headers = APPLY_DELETE_EMAIL_HEADER;
                mail($to_email, $subject, $body, $headers);
            }
            $message = APPLY_DELETE;
            header("location:".FRONT_ROOT."Home/Index");
        }

        public function AcceptApplicant(array $parameters)
        {
            Utils::checkCompany();


            $this->jobOfferDAO->Delete((int)$parameters["jobOfferId"]);

            $student = $this->studentController->GetStudentByUserId((int)$parameters["studentId"]);

            mail($student->getEmail(), APPLY_ACCEPT_EMAIL_SUBJECT, APPLY_ACCEPT_EMAIL . $parameters["companyName"] , APPLY_ACCEPT_EMAIL_HEADER); //thanking mail

            $message = "<h4 class = 'text-center' style='color: greenyellow;'> El estudiante " . $student->getFirstName() ." ". $student->getLastName() . " ha sido aceptado </h4>";
            header('location:'.FRONT_ROOT.'Home/Index');
        }


        public function ShowAddView(): void
        {
            
            $companyController = new CompanyController;
            $jobPositionController = new JobPositionController;
            $companyList = array();
            
            if (!Utils::isCompany()) 
                $companyList = $companyController->GetAll(true);
            else
                array_push($companyList, $companyController->GetCompanyById($_SESSION["loggedUser"]->getCompanyId()));
            
            $jobPositionList = $jobPositionController->GetAll();
            
            require_once(VIEWS_PATH."job-offer-add.php");
        }


        public function ShowListView(): void
        {
            Utils::checkUserLoggedIn();
            
            $jobOfferList = $this->GetAll();

            require_once(VIEWS_PATH."job-offer-list.php");
        }


        public function ShowInfoView(array $parameters): void
        {
            Utils::checkUserLoggedIn();
            
            $jobOffer = $this->jobOfferDAO->GetJobOfferById($parameters['jobOfferId']);

            if (Utils::isAdmin() || Utils::isCompany())
                $applicants = $this->studentController->GetApplicants($jobOffer->getJobOfferId());
            else if (Utils::isStudent())
            {
                $applicationList = $this->GetStudentApplications($_SESSION['loggedUser']->getUserId());
                $applications = array();
                if (!empty($applicationList))
                {
                    foreach ($applicationList as $application)
                    {
                        array_push($applications, $application['jobOffer']->getJobOfferId());
                    }
                }
            }
            require_once(VIEWS_PATH."job-offer-info.php");
        }

        public function ShowOwnJobOffersListView(): void
        {
            Utils::checkCompany();
            
            $jobOfferList = $this->jobOfferDAO->GetAll(FILTER_COMPANY);

            require_once(VIEWS_PATH."job-offer-list.php");
        }


        public function FilterByName(array $parameters)
        {
            Utils::checkUserLoggedIn();

            if (Utils::isStudent())
                $isLookingForJob = $this->jobOfferDAO->IsUserIdInOffer($_SESSION["loggedUser"]->getUserId());
           
            if (empty($parameters["nameToFilter"]))
                $this->ShowListView();
            else
            {
                $jobPositionList  = $this->jobPositionController->GetJobPositionByName($parameters["nameToFilter"]);
                $jobOfferList = $this->GetAll();
                $jobOfferFiltered = array();

                if (!empty($jobPositionList))
                {
                    foreach ($jobPositionList as $jobPosition)
                    {
                        foreach ($jobOfferList as $jobOffer)
                        {
                            if ($jobPosition->getJobPositionId() == $jobOffer->getJobPositionId()) {
                                array_push($jobOfferFiltered, $jobOffer);
                            }
                        }
                    }
                } 
                else
                {
                    $msgErrorFilter = ERROR_JOBOFFER_FILTER;
                    $jobOfferList = $this->jobOfferDAO->GetAll(FILTER_ALL);
                }

                $jobOfferList = array();
                $jobOfferList = $jobOfferFiltered;

                require_once(VIEWS_PATH."job-offer-list.php");
            }
        }


        public function ShowEditView(array $parameters): void
        {
            Utils::checkAdminOrCompany();
        
            $jobOffer = $this->jobOfferDAO->GetJobOfferById($parameters['jobOfferId']);
            
            $jobPositionList = $this->jobPositionDAO->GetAll();
            
            array_unshift($jobPositionList, $jobOffer->getJobPosition());

            $companyList = $this->companyDAO->GetAll();
            array_unshift($companyList, $jobOffer->getCompany());

            require_once(VIEWS_PATH."job-offer-edit.php");
        }


        public function ShowApplicationsView()
        {
            $jobOfferListAll = $this->GetAll();
            $jobOfferList = array();
            $userList = array();

            foreach ($jobOfferListAll as $jobOffer)
            {
                /* array_push($jobOfferList[$jobOffer], $this->userController->getUserById($jobOffer->getUserId())); */ //Associative Array for multiple applicants
                if(!is_null($jobOffer->getUserId()))
                {
                    array_push($jobOfferList, $jobOffer);
                    array_push($userList, $this->userController->getUserById($jobOffer->getUserId()));
                }
            }
            require_once(VIEWS_PATH."student-application.php");
        }


        public function GeneratePDF(array $parameters)
        {
            $jobOffer = $this->GetJobOfferById($parameters['jobOfferId']);
            $applicants = $this->studentController->GetApplicants($parameters['jobOfferId']);
            $this->CreatePDF($jobOffer, $applicants);

            require_once(VIEWS_PATH."job-offer-list.php");
        }


        public function CreatePDF(JobOffer $jobOffer, array $applicants): void //must be created in another function because of how FPDF works
        {
            ob_end_clean(); //clears
            $pdf=new FPDF();

            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 20);
            $pdf->Cell(60,20,$jobOffer->getCompanyName());
            $pdf->Ln(20);   //line break

            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(60,20,"Ciudad: ");
            $pdf->SetFont('Arial', '', 16);
            $pdf->Cell(60,20,$jobOffer->getCompany()->getCity());
            $pdf->Ln(20);

            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(60,20,"Puesto Laboral: ");
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(60,20,$jobOffer->getJobPosition()->getDescription());
            $pdf->Ln(20);

            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(60,20,$jobOffer->getDescription());
            $pdf->Ln(20);
            
            $pdf->SetFont('Arial', 'B', 14);
            if (!empty($applicants))
            {
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->Cell(60,20,"Usuarios postulados:");
                $pdf->Ln(20);
                foreach ($applicants as $applicant)
                {
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(20,10,"ID: ".$applicant->getUserId());
                    $pdf->Cell(60,10,"Name: ".$applicant->getFirstName()." ".$applicant->getLastName());
                    $pdf->Cell(60,10,"Email: ".$applicant->getEmail());
                    $pdf->Ln(8);
                }
            } else
                $pdf->Cell(60, 20,"No hay usuarios postulados.");
            $pdf->Ln(20);


            $pdf->Output();
        }


        public function GetStudentApplications(int $userId): array
        {
            return $this->jobOfferDAO->GetStudentApplications($userId);
        }
    }
?>