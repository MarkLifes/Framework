<?php
namespace Itxiao6\Framework;
use Itxiao6\Framework\Component\Whoops\Exception;

/**
 * 框架核心组件
 * Class Kernel
 * @package Itxiao6\Framework
 */
class Framework_Kernel
{
    /**
     * 组件
     * @var array
     */
    protected $component = [];
    /**
     * 实例化
     * @var array
     */
    protected $object = [];

    /**
     * 获取实例
     */
    public static function getInterface()
    {
        return new static();
    }

    /**
     * 添加组件
     * @param $name
     * @param $class
     * @param array $param
     * @return $this
     * @throws Exception
     */
    function addComponent($name,$class,$param = [])
    {
        if(!class_exists($class)){
//            throw new Exception('组件不存在');
        }
        $this -> component[$name]['name'] = $name;
        $this -> component[$name]['class'] = $class;
        $this -> component[$name]['param'] = $param;
        return $this;
    }

    /**
     * 注册组件
     * @param $name
     * @return mixed
     */
    function registerComponent($name)
    {
        return $this -> component[$name]['class']::getInterface(...$this -> component[$name]['param']);
    }
    /**
     * 使用组件
     */
    function useComponent()
    {

    }

    /**
     * 清除组件
     */
    function clearComponent()
    {

    }
}
include_once(__DIR__.'/../vendor/autoload.php');
/**
 * 使用配置组件
 */
echo Framework_Kernel::getInterface() -> addComponent('配置',\Itxiao6\Framework\Component\Config\Config::class,[__DIR__.'/../config/']) -> registerComponent('配置') -> get('app','name')."\n";