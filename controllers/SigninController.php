<?php

// Авторизация

define("SECRET_SALT", "4e2H34b3hbsd2vCD@!h1j");

class SigninController extends BaseController
{
    private $signinModel;
    private $helper;

    public function __construct()
    {
        $this->signinModel = new Signin();
        $this->helper = new Helper();
    }

    public function main($data = 0)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = json_decode(file_get_contents("php://input"), true);

            // Проверяем на наличие всех обязательных данных
            if (!isset($data['password']) || !isset($data['email'])) {
                return $this->showBadRequest("validation");
            }

            // Проверяем на валидность
            if (!is_string($data['email']) || !preg_match("/^((([0-9A-Za-z]{1}[-0-9A-z\.]*[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]*[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u", $data['email'])) {
                return $this->showBadRequest("validation");
            }
            if (!is_string($data['password'])) {
                return $this->showBadRequest("validation");
            }

            // Подготавливаем данные
            $email = htmlentities($data['email']);
            $hashedPassword = md5(htmlentities($data['password']) . SECRET_SALT);

            $userInfo = $this->signinModel->getUserInfo($email, $hashedPassword);
            if ($userInfo['count'] === '0') {
                return $this->showNotAuthorized("Передан неверный логин или пароль");
            }

            $token = $this->helper->generateToken();
            $tokenTime = time() + 30 * 60;
            $userId = $userInfo['user_id'];
            $this->signinModel->auth($userId, $token, $tokenTime);

            $this->answer = [ "token" => "Bearer " . $token ];
            $this->sendAnswer();
        } else {
            $this->showNotAllowed();
        }
    }
}
