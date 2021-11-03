<?php
    namespace Controllers;

    use DAO\JobOfferDAO as JobOfferDAO;
    use Models\JobOffer as JobOffer;
    use Models\JobPosition as JobPosition;
    use Models\Company as Company;
    use Controllers\CompanyController as CompanyController;
    use Controllers\JobPositionController as JobPositionController;
    use Utils\Utils as Utils;
    use DateTime;

    class JobOfferController
    {
        private $jobOfferDAO;
        private $jobPositionController;

        public function __construct()
        {
            $this->jobOfferDAO = new JobOfferDAO();
            $this->jobPositionController = new JobPositionController;
        }


        public function ShowAddView()
        {
            Utils::checkAdmin();
            
            $companyController = new CompanyController;
            $jobPositionController = new JobPositionController;

            $companyList = $companyController->GetAll();
            $jobPositionList = $jobPositionController->GetAll();

            require_once(VIEWS_PATH."job-offer-add.php");
        }

        public function ShowListView()
        {
            Utils::checkUserLoggedIn();

            // Update offers with data from API (JobPositions and Careers)

            // $studentController = new StudentController();

            // $careerId = $studentController->getCareerIdByStudentId($_SESSION['loggedUser']['associatedId']);
            
            $jobOfferList = $this->GetAll();
            require_once(VIEWS_PATH."job-offer-list.php");
        }


        public function ShowEditView($parameters)
        {
            Utils::checkAdmin();
            
            $jobOffer = $this->jobOfferDAO->getJobOfferById($parameters['jobOfferId']);

            require_once(VIEWS_PATH."job-offer-edit.php");
        }

        public function FilterByName($parameters)
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
                    } 
                    else
                    {
                        $msgErrorFilter = '<strong style="color:red; font-size:small;"> Ninguna Compañia contiene el nombre ingresado </strong>'; // TODO: move HTML code to view

                        $jobOfferList = $this->jobOfferDAO->GetAll();
                    }

                    $jobOfferList = array();
                    $jobOfferList = $jobOfferFiltered;

                    require_once(VIEWS_PATH."job-offer-list.php");

                }
            }
        }


        public function Edit($parameters)
        {
            // Utils::checkAdmin();
            
            // $companyId = $parameters['id'];
            // $name = $parameters['name'];
            // $yearFoundation = $parameters['yearFoundation'];
            // $city = $parameters['city'];
            // $description = $parameters['description'];           
            // $logo = $parameters['logo']['name'];
            // $tmp_name = $parameters['logo']['tmp_name'];
            // $email = $parameters['email'];
            // $phoneNumber = $parameters['phoneNumber'];

            // $this->companyDAO->editCompany($companyId, $name, $yearFoundation, $city, $description, $logo, $tmp_name, $email, $phoneNumber);

            // $this->ShowInfo($parameters);
        }


        public function Delete($parameters)
        {
            Utils::checkAdmin();

            $this->jobOfferDAO->Delete($parameters['jobOfferId']);

            $this->ShowListView();
        }


        public function Add($parameters)
        {
            Utils::checkAdmin();

            // Bind parameters to JobOffer object
            // Call DAO
            $jobOffer = new JobOffer;
            $jobPosition = new JobPosition();
            $jobPosition->setJobPositionId($parameters["jobPositionId"]);
            $jobOffer->setCompany(new Company($parameters["companyId"]));
            $jobOffer->setJobPosition($jobPosition);
            $jobOffer->setDescription($parameters["description"]);
            $jobOffer->setPublicationDate(new DateTime($parameters["publicationDate"]));
            $jobOffer->setExpirationDate(new DateTime($parameters["expirationDate"]));
            
            $this->jobOfferDAO->Add($jobOffer);

            $this->ShowListView();
        }

        
        public function GetAll(): array
        {
            $jobPositionController = new JobPositionController;
            $companyController = new CompanyController;
            
            $jobOffers = $this->jobOfferDAO->GetAll(); // Array of JobOffer objects (incomplete)
            
            $jobPositions = $jobPositionController->GetAll();
            
            $companies = $companyController->GetAll();
            

            foreach ($jobOffers as $jobOffer)
            {
                $jobOffer->setJobPosition($jobPositions[$jobOffer->getJobPositionId()]);
                $jobOffer->setCompany($companies[$jobOffer->getCompanyId()]);
            }

            return $jobOffers;
        }
    }
