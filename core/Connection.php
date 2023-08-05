<?php
class Connection
{
    private static $instance = null, $conn = null;

    private function __construct($config)
    {
        try {
            $dsn = 'mysql:dbname=' . $config['db'] . ';host=' . $config['host'];
            $option = [
                // PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAME utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            $con = new PDO($dsn, $config['user'], '', $option);
            self::$conn = $con;
        } catch (Exception $exception) {
            $mess = $exception->getMessage();
            $data['message'] = $mess;
            App::$app->loadError('database', $data);
            die();
            // if (preg_match('/Access denied for user/', $mess)) {
            //     die('Lỗi kết nối cơ sở dữ liệu');
            // }
            // if (preg_match('/Unknown database/', $mess)) {
            //     die('Không tìm thấy cơ sở dữ liệu');
            // }
        }
    }

    public static function getInstance($config)
    {
        if (self::$instance == null) {
            $connection = new Connection($config);
            self::$instance = self::$conn;
        }

        return self::$instance;
    }
}
