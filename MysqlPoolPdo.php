<?php
/**
 * 数据库连接池(PDO方式)
 * @author xutao
 * Date: 2019/1/24
 * time: 17:35
 */
require "AbstractPool.php";
class MysqlPoolPdo extends AbstractPool
{
    protected $dbConfig = array(
        'host' => 'mysql:host=127.0.0.1:3306;dbname=book',
        'port' => 3306,
        'user' => 'book',
        'password' => 'Y442D4e5sfZTECxy',
        'database' => 'book',
        'charset' => 'utf8',
        'timeout' => 10,
    );
    public static $instance;
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    protected function createDb()
    {
        return new PDO($this->dbConfig['host'], $this->dbConfig['user'], $this->dbConfig['password']);
    }
}
$httpServer = new swoole_http_server('127.0.0.1', 9501);
$httpServer->set(
    ['worker_num' => 1]
);
$httpServer->on("WorkerStart", function () {
    MysqlPoolPdo::getInstance()->init();
});
$httpServer->on("request", function ($request, $response) {
    $db = null;
    $obj = MysqlPoolPdo::getInstance()->getConnection();
    if (!empty($obj)) {
        $db = $obj ? $obj['db'] : null;
    }
    if ($db) {
        $db->query("select sleep(2)");
        $stmt = $db->query("select * from guestbook limit 1");
		$data = array();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){  //将PDOStatement对象转换为数组
			$data[] = $row;
		}
        MysqlPoolPdo::getInstance()->free($obj);
        $response->end(json_encode($data));
    }
});
$httpServer->start();
