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

    public function auth($userId, $token, $tokenTime)
    {
        $query = "
            INSERT INTO `connects`
                SET `connect_user_id` = $userId,
                    `connect_token` = '$token',
                    `connect_token_time` = FROM_UNIXTIME($tokenTime);
        ";
        return mysqli_query($this->connect, $query);
    }

    public function checkIfUserAuthorized()
    {

        print_r(123);
    //     if (!isset($_COOKIE['uid']) || !isset($_COOKIE['t']) || !isset($_COOKIE['tt'])) {
    //         return false;
    //     }

    //     $userId = htmlentities($_COOKIE['uid']);
    //     $token = htmlentities($_COOKIE['t']);
    //     $tokenTime = htmlentities($_COOKIE['tt']);
    //     $query = "
    //         SELECT `connect_id`
    //         FROM `connects`
    //         WHERE `connect_user_id` = $userId
    //             AND `connect_token` = '$token';
    //         ";
    //     $result = mysqli_query($this->connect, $query);
    //     if (mysqli_num_rows($result) === 0) {
    //         return false;
    //     }
    //     if ($tokenTime < time()) {
    //         $newToken = $this->helper->generateToken();
    //         $newTokenTime = time() + 30 * 60;
    //         setcookie("uid", $userId, time() + 2 * 24 * 3600, '/');
    //         setcookie("t", $newToken, time() + 2 * 24 * 3600, '/');
    //         setcookie("tt", $newTokenTime, time() + 2 * 24 * 3600, '/');
    //         $connectId = $result['connect_id'];
    //         $query = "
    //             UPDATE `connects`
    //             SET `token` = '$newToken',
    //             `token_time` = FROM_UNIXTIME($newTokenTime)
    //             WHERE `connect_id` = $connectId;
    //         ";
    //         mysqli_query($this->connect, $query);
    //     }
    //     return true;
    }
}
