<?php

class Signin extends BaseModel
{
    public function getUserInfo($email, $hashedPassword)
    {
        $query = "
            SELECT COUNT(*) AS `count`, `user_id`
            FROM `users`
            WHERE `user_email` = '$email' AND `user_password` = '$hashedPassword';
        ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result);
    }

    public function auth($userId, $token)
    {
        $query = "
            SELECT *
                FROM `connects`
                WHERE `connect_user_id` = '$userId';
        ";
        $result = mysqli_query($this->connect, $query);
        if (mysqli_num_rows($result) === 0) {
            $query = "
                INSERT INTO `connects`
                    SET `connect_user_id` = $userId,
                        `connect_token` = '$token';
            ";
            return mysqli_query($this->connect, $query);
        } else {
            $query = "
                UPDATE `connects`
                    SET `connect_token` = '$token'
                    WHERE `connect_user_id` = $userId;
            ";
            mysqli_query($this->connect, $query);
        }
    }
}
