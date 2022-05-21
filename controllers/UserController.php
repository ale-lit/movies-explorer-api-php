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
        } else if ($_SERVER['REQUEST_METHOD'] === 'PATCH' && apache_request_headers()['Authorization'] && $this->isAuthorized) {
            $data = json_decode(file_get_contents("php://input"), true);

            // Проверяем на наличие всех обязательных данных
            if (!isset($data['name']) || !isset($data['email'])) {
                return $this->showBadRequest("Переданы некорректные данные");
            }

            // Проверяем на валидность            
            if (mb_strlen($data['name']) < 2 || mb_strlen($data['name']) > 30 || !is_string($data['name'])) {
                return $this->showBadRequest("Переданы некорректные данные (имя пользователя)");
            }
            if (!is_string($data['email']) || !preg_match("/^((([0-9A-Za-z]{1}[-0-9A-z\.]*[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]*[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u", $data['email'])) {
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
        } else {
            $this->showNotAllowed();
        }
    }
}
