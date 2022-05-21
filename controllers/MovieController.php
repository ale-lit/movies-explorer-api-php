<?php

class MovieController extends BaseController
{
    private $movieModel;
    public $isAuthorized;

    public function __construct()
    {
        $this->movieModel = new Movie();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
    }

    public function main($data = 0)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->answer = $this->movieModel->getAll();
            $this->sendAnswer();
        } else {
            $this->showNotAllowed();
        }
    }

    public function saved()
    {
        if ($this->isAuthorized) {
            // Получаем id пользователя
            // TODO: Вынести в отдельную функцию
            if (!isset(apache_request_headers()['Authorization'])) {
                return false;
            }        
            $tokenData = str_replace("Bearer ", "", htmlentities(apache_request_headers()['Authorization']));
            $tokenData = json_decode(base64_decode($tokenData), true);
            $userId = htmlentities($tokenData['uid']);

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->answer = $this->movieModel->getAllSaved($userId);
                $this->sendAnswer();
            } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents("php://input"), true);

                // Проверяем на наличие id movie
                if (!isset($data['movieId'])) {
                    return $this->showBadRequest("Переданы некорректные данные");
                }
                
                $movieId = htmlentities($data['movieId']);

                // Проверяем на валидность
                if (!preg_match("/^[0-9]*$/", $movieId)) {
                    return $this->showBadRequest("validation");
                }

                if ($this->movieModel->add($movieId, $userId)) {
                    $this->answer = $data;
                    $this->sendAnswer();
                }
            } else {
                $this->showNotAllowed();
            }
        } else {
            $this->showNotAuthorized("Ошибка доступа");
        }
    }
}
