<?php

class MovieController extends BaseController
{
    private $movieModel;

    public function __construct()
    {
        $this->movieModel = new Movie();
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
}
