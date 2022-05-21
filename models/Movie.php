<?php

class Movie extends BaseModel
{
    public function getAll()
    {        
        $query = "
            SELECT `movie_id` AS 'id', `movie_name_ru` AS 'nameRU', `movie_name_en` AS 'nameEN',
                `movie_director` AS 'director', `movie_country` AS 'country', `movie_year` AS 'year',
                `movie_duration` AS 'duration', `movie_description` AS 'description', `movie_trailer` AS 'trailerLink',
                `movie_image` AS 'image'
                    FROM `movies`
        ";
        $result = mysqli_query($this->connect, $query);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($result as $key => $value) {
            foreach ($value as $k => $val) {
                if ($k === 'image') {
                    $result[$key]['image'] = [
                        'formats' => [
                            'thumbnail' => [
                                'url' => $val
                            ],
                            'small' => [
                                'url' => $val
                            ]
                        ],
                        'url' => $val
                    ];
                }
            }
        }
        return $result;
    }

    public function add($movieId, $userId)
    {
        $query = "
            INSERT INTO `saved`
                SET `saved_user_id` = $userId,
                    `saved_movie_id` = $movieId;
        ";
        return mysqli_query($this->connect, $query);
    }

    public function getAllSaved($userId)
    {
        $query = "
            SELECT `movie_id` AS 'id', `movie_name_ru` AS 'nameRU', `movie_name_en` AS 'nameEN',
                `movie_director` AS 'director', `movie_country` AS 'country', `movie_year` AS 'year',
                `movie_duration` AS 'duration', `movie_description` AS 'description', `movie_trailer` AS 'trailerLink',
                `movie_image` AS 'image'
                    FROM `movies`
                LEFT JOIN `saved` ON `saved_user_id` = $userId
                WHERE `movie_id` = `saved_movie_id`;
        ";
        $result = mysqli_query($this->connect, $query);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($result as $key => $value) {
            foreach ($value as $k => $val) {
                if ($k === 'image') {
                    $result[$key]['image'] = [
                        'formats' => [
                            'thumbnail' => [
                                'url' => $val
                            ],
                            'small' => [
                                'url' => $val
                            ]
                        ],
                        'url' => $val
                    ];
                }
            }
        }
        return $result;
    }
}
