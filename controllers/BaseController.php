<?php

abstract class BaseController
{
    protected $answer;

    abstract function main($id = 0);

    protected function sendAnswer()
    {
        header('HTTP/1.1 200 OK');
        header('Content-type: application/json');
        echo json_encode($this->answer, JSON_UNESCAPED_UNICODE);
    }

    protected function showNotFound()
    {
        header('HTTP/1.1 404 Not Found');
    }

    protected function showNotAllowed()
    {
        header('HTTP/1.1 405 Not Allowed');
    }

    protected function showBadRequest()
    {
        header('HTTP/1.1 400 Bad Request');
    }

    protected function showNotAuthorized()
    {
        header('HTTP/1.1 401 Unauthorized');
    }
}