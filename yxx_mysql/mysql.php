<?php
require_once('Config/DbConfig.php');
class Mysql {
    private $host;
    private $user;
    private $pwd;
    private $dbName;
    private $charset;
	private $port;
    private $conn = null; // 保存连接的资源
    private $config;
    public function __construct($user) {
        // 应该是在构造方法里,读取配置文件
        // 然后根据配置文件来设置私有属性
        // 此处还没有配置文件,就直接赋值
		$this->config = DbConfig::$$user;
        $this->host = $this->config['host'];
        $this->user = $this->config['user'];
        $this->pwd = $this->config['password'];
        $this->dbName = $this->config['dbname'];
		$this->charset=$this->config['charset'];
		$this->port=$this->config['port'];
        // 连接
        $this->connect($this->host,$this->user,$this->pwd,$this->dbName,$this->port);

        // 切换库
       // $this->switchDb($this->dbName);
        // 设置字符集
        $this->setChar($this->charset);
   
   
    }

    // 负责连接
    private function connect($h,$u,$p,$db,$port) {
        $conn = mysqli_connect($h,$u,$p,$db,$port);
        $this->conn = $conn;
    }

    // 负责切换数据库,网站大的时候,可能用到不止一个库
    public function switchDb($db) {
        $sql = 'use ' . $db;
        $this->query($sql);
    }

    // 负责设置字符集
    public function setChar($char) {
        $sql = 'set names ' .  $char;
        $this->query($sql);
    }

    // 负责发送sql查询
    public function query($sql) {
        return mysqli_query($this->conn,$sql);
    }

    // 负责获取多行多列的select 结果
    public function getAll($sql) {
        $list = array();

        $rs = $this->query($sql);
        if(!$rs) {
            return false;
        }

        while($row = mysql_fetch_assoc($rs)) {
            $list[] = $row;
        }

        return $list;

    }

    // 获取一行的select 结果
    public function getRow($sql) {
        $rs = $this->query($sql);
       
        if(!$rs) {
            return false;
        }

        return mysql_fetch_assoc($rs);
    }

    // 获取一个单个的值
    public function getOne($sql) {
        $rs = $this->query($sql);
        if(!$rs) {
            return false;
        }

        $row = mysql_fetch_row($rs);

        return $row[0];
    }

    public function close() {
        mysql_close($this->conn);
    }
}
?>