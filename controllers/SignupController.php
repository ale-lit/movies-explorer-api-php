<?php

// Регистрация

define("SECRET_SALT", "4e2H34b3hbsd2vCD@!h1j");

class SignupController extends BaseController
{
    private $signupModel;

    public function __construct()
    {
        $this->signupModel = new Signup();
    }

    public function main($data = 0)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = json_decode(file_get_contents("php://input"), true);

            // Проверяем на наличие всех обязательных данных
            if (!isset($data['name']) || !isset($data['password']) || !isset($data['email'])) {
                return $this->showBadRequest("Переданы некорректные данные");
            }

            // Проверяем на валидность            
            if (mb_strlen($data['name']) < 2 || mb_strlen($data['name']) > 30 || !is_string($data['name'])) {
                return $this->showBadRequest("Переданы некорректные данные (имя пользователя)");
            }
            if (!is_string($data['email']) || !preg_match("/^((([0-9A-Za-z]{1}[-0-9A-z\.]*[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]*[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u", $data['email'])) {
                return $this->showBadRequest("Переданы некорректные данные (Email)");
            }
            if (!is_string($data['password'])) {
                return $this->showBadRequest("Переданы некорректные данные (пароль)");
            }

            // Подготавливаем данные
            $name = htmlentities($data['name']);
            $email = htmlentities($data['email']);
            $password = md5(htmlentities($data['password']) . SECRET_SALT);

            // Проверяем на наличие email в базе
            $checkUserEmail = $this->signupModel->checkIfUserExists($email);
            if ($checkUserEmail === '1') {
                return $this->showConflictError();
            }

            if ($this->signupModel->add($name, $email, $password)) {
                $this->answer = [
                    "name" => $name,
                    "email" => $email
                ];
                $this->sendCreated();
            }
        } else {
            $this->showNotAllowed();
        }
    }
}
