<?php

class User extends BaseModel
{    
    public function getUserInfo($userId)
    {
        $query = "
            SELECT `user_email` AS 'email', `user_name` AS 'name'
            FROM `users`
            WHERE `user_id` = $userId;
        ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result);
    }

    public function checkIfUserAuthorized()
    {   
        if (!isset(apache_request_headers()['Authorization'])) {
            return false;
        }

        $tokenData = str_replace("Bearer ", "", htmlentities(apache_request_headers()['Authorization']));

        $tokenData = json_decode(base64_decode($tokenData), true);

        $token = htmlentities($tokenData['t']);
        $userId = htmlentities($tokenData['uid']);

        $query = "
            SELECT `connect_id`
                FROM `connects`
                WHERE `connect_user_id` = $userId
                    AND `connect_token` = '$token';
                ";
        $result = mysqli_query($this->connect, $query);

        if (mysqli_num_rows($result) === 0) {
            return false;
        }

        return true;
    }

    public function edit($name, $email)
    {
        if (!isset(apache_request_headers()['Authorization'])) {
            return false;
        }
        $tokenData = str_replace("Bearer ", "", htmlentities(apache_request_headers()['Authorization']));
        $tokenData = json_decode(base64_decode($tokenData), true);
        $userId = htmlentities($tokenData['uid']);

        $query = "
            UPDATE `users`
                SET `user_name` = '$name',
                    `user_email` = '$email'
            WHERE `user_id` = $userId;
        ";
        return mysqli_query($this->connect, $query);
    }
}
