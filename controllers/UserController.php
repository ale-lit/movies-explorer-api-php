<?php

define("SECRET_SALT", "4e2H34b3hbsd2vCD@!h1j");

class UserController extends BaseController
{
    private $userModel;
    public $isAuthorized;

    public function __construct()
    {
        $this->userModel = new User();
        $this->isAuthorized = $this->userModel->checkIfUserAuthorized();
    }

    public function main($data = 0)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && apache_request_headers()['Authorization'] && $this->isAuthorized) {

            $tokenData = str_replace("Bearer ", "", htmlentities(apache_request_headers()['Authorization']));
            $tokenData = json_decode(base64_decode($tokenData), true);            
            $userId = htmlentities($tokenData['uid']);

            $this->answer = $this->userModel->getUserInfo($userId);;
            $this->sendAnswer();
        } else {
            $this->showNotAllowed();
        }
    }
}
