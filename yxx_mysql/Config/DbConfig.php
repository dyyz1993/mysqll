<?php

/**
 * mysql配置
 * @author walkor
 */
class DbConfig
{
    /**
     * 数据库的一个实例配置，则使用时像下面这样使用
     * $user_array = Db::instance('user')->select('name,age')->from('users')->where('age>12')->query();
     * 等价于
     * $user_array = Db::instance('user')->query('SELECT `name`,`age` FROM `users` WHERE `age`>12');
     * @var array
     */
    public static $user = array(
        'host'    => '119.29.142.43',
        'port'    => 3306,
        'user'    => 'yxx',
        'password' => 'yxx',
        'dbname'  => 'yxx',
        'charset'    => 'utf8',
    );
}