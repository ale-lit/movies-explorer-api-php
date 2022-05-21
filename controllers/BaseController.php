<?php

abstract class BaseController
{
    protected $answer;

    abstract function main($id = 0);

    protected function sendAnswer()
    {
        header('HTTP/1.1 200 OK');
        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: *');

        echo json_encode($this->answer, JSON_UNESCAPED_UNICODE);
    }

    protected function sendCreated()
    {
        header('HTTP/1.1 201 Created');
        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        echo json_encode($this->answer, JSON_UNESCAPED_UNICODE);
    }

    protected function showNotFound()
    {
        header('HTTP/1.1 404 Not Found');
        header('Access-Control-Allow-Origin: *');
    }

    protected function showNotAllowed()
    {
        header('HTTP/1.1 405 Not Allowed');
        header('Access-Control-Allow-Origin: *');
    }

    protected function showBadRequest($message = false)
    {
        header('HTTP/1.1 400 Bad Request');
        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: *');

        if ($message) {
            $this->answer = [ "message" => $message ];
            header('Content-type: application/json');
            echo json_encode($this->answer, JSON_UNESCAPED_UNICODE);
        }
    }

    protected function showConflictError()
    {
        header('HTTP/1.1 409 Conflict');
        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: *');

        $this->answer = [ "message" => "Указанные данные уже есть в базе" ];
        header('Content-type: application/json');
        echo json_encode($this->answer, JSON_UNESCAPED_UNICODE);
    }

    protected function showNotAuthorized($message = false)
    {
        header('HTTP/1.1 401 Unauthorized');
        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: *');

        if ($message) {
            $this->answer = [ "message" => $message ];
            header('Content-type: application/json');
            echo json_encode($this->answer, JSON_UNESCAPED_UNICODE);
        }
    }
}