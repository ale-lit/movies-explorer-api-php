<?php

abstract class BaseModel
{
    protected $connect;

    public function __construct()
    {
        $this->connect = DB::getConnection();
    }
}