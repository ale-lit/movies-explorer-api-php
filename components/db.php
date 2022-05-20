<?php
final class DB
{
    private static $connection = null;

    private function __construct()
    {
        require_once('configs/db.php');
        $connect = mysqli_connect(
            $db['HOST'],
            $db['USER'],
            $db['PASSWORD'],
            $db['DB_NAME']
        );
        mysqli_set_charset($connect, $db['CHARSET']);
        self::$connection = $connect;
    }

    public static function getConnection()
    {
        if (self::$connection == null) {
            new self();
        }
        return self::$connection;
    }

    private function __clone()
    {
    }

    public function __sleep()
    {
    }

    public function __wakeup()
    {
    }
}
