<?php

// Авторизация
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
            if (!is_string($data['email']) || !preg_match(REGEX_EMAIL, $data['email'])) {
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
            $userId = $userInfo['user_id'];

            $this->signinModel->auth($userId, $token);

            $resToken = base64_encode(json_encode([ "uid" => $userId, "t" => $token ]));

            $this->answer = [ "token" => "Bearer " . $resToken ];
            $this->sendAnswer();
        } else {
            $this->showNotAllowed();
        }
    }
}
