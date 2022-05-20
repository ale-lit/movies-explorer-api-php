<?php

class Movie extends BaseModel
{
    public function getAll()
    {        
        include_once('./configs/allmovies.php');
        return $allMovies;
    }
}
