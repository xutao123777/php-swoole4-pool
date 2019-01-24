<?php
/**
 * 数据库连接池协程方式
 * @author xutao
 * Date: 2019/1/24
 * Time: 11:30
 */
require "AbstractPool.php";

class MysqlPoolCoroutine extends AbstractPool
{
    protected $dbConfig = array(
        'host' => '127.0.0.1',
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
        $db = new Swoole\Coroutine\Mysql();
        $db->connect(
            $this->dbConfig
        );
        return $db;
    }
}

$httpServer = new swoole_http_server('0.0.0.0', 9501);
$httpServer->set(
    ['worker_num' => 1]
);
$httpServer->on("WorkerStart", function () {
    //MysqlPoolCoroutine::getInstance()->init()->gcSpareObject();
    MysqlPoolCoroutine::getInstance()->init();
});

$httpServer->on("request", function ($request, $response) {
    $db = null;
    $obj = MysqlPoolCoroutine::getInstance()->getConnection();
    if (!empty($obj)) {
        $db = $obj ? $obj['db'] : null;
    }
    if ($db) {
        $db->query("select sleep(2)");
        $ret = $db->query("select * from guestbook limit 1");
        MysqlPoolCoroutine::getInstance()->free($obj);
        $response->end(json_encode($ret));
    }
});
$httpServer->start();
