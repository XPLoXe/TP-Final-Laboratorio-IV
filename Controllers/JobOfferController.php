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


        public function __construct()
        {
            $this->jobOfferDAO = new JobOfferDAO();
        }


        public function Add($parameters)
        {
            Utils::checkAdmin();

            // Bind parameters to JobOffer object
            // Call DAO
            $jobOffer = new JobOffer;
            $jobOffer->setCompany(new Company($parameters["companyId"]));
            $jobOffer->setJobPosition(new JobPosition($parameters["jobPositionId"]));
            $jobOffer->setDescription($parameters["description"]);
            $jobOffer->setPublicationDate(new DateTime($parameters["publicationDate"]));
            $jobOffer->setExpirationDate(new DateTime($parameters["expirationDate"]));
            
            $this->jobOfferDAO->Add($jobOffer);

            $this->ShowListView();
        }


        public function Delete($parameters)
        {
            Utils::checkAdmin();

            $this->jobOfferDAO->Delete($parameters['jobOfferId']);

            $this->ShowListView();
        }


        public function Edit($parameters)
        {
            // Utils::checkAdmin();
            
            // $companyId = $parameters['id'];
            // $name = $parameters['name'];
            // $yearOfFoundation = $parameters['yearOfFoundation'];
            // $city = $parameters['city'];
            // $description = $parameters['description'];           
            // $logo = $parameters['logo']['name'];
            // $tmp_name = $parameters['logo']['tmp_name'];
            // $email = $parameters['email'];
            // $phoneNumber = $parameters['phoneNumber'];

            // $this->companyDAO->Edit($companyId, $name, $yearOfFoundation, $city, $description, $logo, $tmp_name, $email, $phoneNumber);

            // $this->ShowInfo($parameters);
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
