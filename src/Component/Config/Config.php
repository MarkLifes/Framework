<?php
namespace Itxiao6\Framework\Component\Config;

/**
 * 配置类
 * Class Config
 * @package Itxiao6\Framework\Component\Config
 */
class Config implements \Itxiao6\Framework\AbstractInterface\Component
{
    /**
     * 配置文件路径
     * @var string
     */
    protected $path = '';

    /**
     * 获取组件实例
     * @return Config|mixed
     */
    public static function getInterface()
    {
        return new self(...func_get_args());
    }

    /**
     * Config constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this -> path = $path;
    }

    /**
     * 配置
     * @var array
     */
    protected $config = [];
    /**
     * 读取配置
     * @param string $type
     * @param null $key
     * @return bool
     */
    public function get($type='app',$key=null)
    {
        /**
         * 判断配置文件是否加载过
         */
        if(!isset($this -> config[$type])){
            /**
             * 判断配置文件是否存在
             */
            if(file_exists($this -> path.$type.'.php')){
                $this -> config[$type] = require($this -> path.$type.'.php');
            }else{
                return false;
            }
        }
        /**
         * 是否读取全部配置
         */
        if($key===null){
            /**
             * 返回要取得的值
             */
            return $this -> config[$type];
        }else{
            /**
             * 返回要取得的值
             */
            return $this -> config[$type][$key];
        }
    }
    /**
     * 设置配置
     * @param string $type
     * @param array | string $value
     * @param null | string $key
     * @return mixed
     */
    public function set($type,$value,$key=null)
    {
        if($key===null){
            return $this -> config[$type] = $value;
        }else{
            $this -> config[$type][$key] = $value;
        }
    }
}