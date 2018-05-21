<?php
namespace Itxiao6\Framework\Component\Database;
use Itxiao6\Database\Capsule\Manager;
use Illuminate\Container\Container;
use Itxiao6\Framework\AbstractInterface\Event;
use Itxiao6\Framework\Component\Config\Config;

/**
 * 数据库类
 * Class DB
 * @package Itxiao6\Framework\Component
 */
class DB extends Manager
{

    /**
     * 获取PDO 实例
     * @return \PDO
     */
    public static function GET_PDO()
    {
        if(!Event::get_databases_status()){
            Event::databases_connection();
        }
        return static::connection() -> getPdo();
    }

    /**
     * 获取数据库sql Log
     * @return bool
     * @throws \Exception
     */
    public static function DB_LOG(){
        # 数据库是否连接
        if(Event::get_databases_status()){
            return false;
        }
        # 判断是否开启了DB_log
        if(Config::get('sys','database_log')){
            return self::getQueryLog();
        }else{
//            TODO 未开启DB_log
        }
    }
    /**
     * Dynamically pass methods to the default connection.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if(!Event::get_databases_status()){
            Event::databases_connection();
        }
        return static::connection()->$method(...$parameters);
    }

    /**
     * 实例化DB
     * @param Container|null $container
     * @return static
     */
    public static function getInterface(Container $container = null)
    {
        return new static($container,false);
    }

    /**
     * 创建一个 数据库容器
     * DB constructor.
     * @param Container|null $container
     * @param bool $is_cache_connection
     */
    public function __construct(Container $container = null,$is_cache_connection = true)
    {
        if((!Event::get_databases_status()) && $is_cache_connection){
            Event::databases_connection();
        }
        $this->setupContainer($container ?: new Container);

        // Once we have the container setup, we will setup the default configuration
        // options in the container "config" binding. This will make the database
        // manager work correctly out of the box without extreme configuration.
        $this->setupDefaultConfiguration();

        $this->setupManager();
    }

    /**
     * 通过table 获取一个 Query Builder
     * @param string $table
     * @param null $connection
     * @return \Itxiao6\Database\Query\Builder
     */
    public static function table($table, $connection = null)
    {
        if(!Event::get_databases_status()){
            Event::databases_connection();
        }
        return parent::table($table, $connection);
    }

    /**
     * 获取一个 Schema Builder
     * @param null $connection
     * @return \Itxiao6\Database\Schema\Builder
     */
    public static function schema($connection = null)
    {
        if(!Event::get_databases_status()){
            Event::databases_connection();
        }
        return parent::schema($connection);
    }
}