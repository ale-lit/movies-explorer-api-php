<?php

class Signup extends BaseModel
{
    public function checkIfUserExists($email)
    {
        $query = "
            SELECT COUNT(*) AS `count`
                FROM `users`
                WHERE `user_email` = '$email';
        ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result)['count'];
    }

    public function add($name, $email, $password)
    {
        $query = "
            INSERT INTO `users`
                SET `user_name` = '$name',
                    `user_email` = '$email',
                    `user_password` = '$password';
        ";
        return mysqli_query($this->connect, $query);
    }
}
