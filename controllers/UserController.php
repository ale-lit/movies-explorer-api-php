<?php

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
        if ($this->isAuthorized) {
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'GET':
                    $this->get();
                    break;
                case 'PATCH':
                    $this->patch();
                    break;
                default:
                    $this->showNotAllowed();
                    break;
            }
        } else {
            $this->showNotAuthorized();
        }
    }

    public function getUserInfoByToken()
    {
        if (apache_request_headers()['Authorization']) {
            $tokenData = str_replace("Bearer ", "", htmlentities(apache_request_headers()['Authorization']));
            $tokenData = json_decode(base64_decode($tokenData), true);
            return $tokenData;
        } else {
            return false;
        }
    }

    public function get()
    {           
        $userId = $this->getUserInfoByToken()['uid'];

        $this->answer = $this->userModel->getUserInfo($userId);
        $this->sendAnswer();
    }

    public function patch()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        // Проверяем на наличие всех обязательных данных
        if (!isset($data['name']) || !isset($data['email'])) {
            return $this->showBadRequest("Переданы некорректные данные");
        }

        // Проверяем на валидность            
        if (mb_strlen($data['name']) < 2 || mb_strlen($data['name']) > 30 || !is_string($data['name'])) {
            return $this->showBadRequest("Переданы некорректные данные (имя пользователя)");
        }
        if (!is_string($data['email']) || !preg_match(REGEX_EMAIL, $data['email'])) {
            return $this->showBadRequest("Переданы некорректные данные (Email)");
        }

        // Подготавливаем данные
        $name = htmlentities($data['name']);
        $email = htmlentities($data['email']);

        if ($this->userModel->edit($name, $email)) {
            $this->answer = [
                "name" => $name,
                "email" => $email
            ];
            $this->sendAnswer();
        }
    }
}
