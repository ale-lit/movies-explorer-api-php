<?php

// Регистрация
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
            if (!is_string($data['email']) || !preg_match(REGEX_EMAIL, $data['email'])) {
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
