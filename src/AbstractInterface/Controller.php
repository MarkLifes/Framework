<?php
namespace Itxiao6\Swoole\AbstractInterface;

/**
 * 控制器基础类
 * Class Controller
 * @package Itxiao6\Swoole\AbstractInterface
 */
abstract class Controller
{
    /**
     * 操作名称
     * @var null
     */
    protected $actionName = null;
    /**
     * 控制器名称
     * @var null
     */
    protected $controolerName = null;
    /**
     * 请求
     * @var null
     */
    protected $request = null;
    /**
     * 响应
     * @var null
     */
    protected $response = null;

    /**
     * 控制器构造方法
     * @param $actionName
     * @param $controolerName
     * @param $request
     * @param $response
     * @throws \Throwable
     */
    protected function __construct($actionName,$controolerName,$request,$response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->controolerName = $controolerName;
        $this->actionName = $actionName;
        if($actionName == '__construct'){
            $this->response()->withStatus(Status::CODE_BAD_REQUEST);
        }else{
            $this->__hook( $actionName);
        }
    }

    /**
     * 获取接口
     * @param $actionName
     * @param $controolerName
     * @param $request
     * @param $response
     * @return Controller
     * @throws \Throwable
     */
    public static function getInterface($actionName,$controolerName,$request,$response)
    {
        return new static($actionName,$controolerName,$request,$response);
    }

    /**
     * 控制器钩子
     * @param $actionName
     * @throws \Throwable
     */
    protected function __hook($actionName)
    {
        try{
            /**
             * 尝试调用用户自定义的方法
             */
            $this->onRequest($actionName);
        }catch (\Exception $exception){
            /**
             * 使用默认的
             */
            try{
                $ref = new \ReflectionClass(static::class);
                if($ref->hasMethod($actionName) && $ref->getMethod( $actionName)->isPublic()){
                    $this->$actionName();
                }else{
                    $this->actionNotFound($actionName);
                }
            }catch (\Throwable $throwable){
                try{
                    /**
                     * 尝试使用用户自定义的异常处理
                     */
                    $this->onException($throwable,$actionName);
                }catch (\Throwable $exception){
                    /**
                     * 使用默认的
                     */
                    throw $exception;
                }
            }
            try{
                /**
                 * 尝试使用自定义的
                 */
                $this->afterAction($actionName);
            }catch (\Throwable $throwable){
                try{
                    /**
                     * 异常处理
                     */
                    $this->onException($throwable,$actionName);
                }catch (\Throwable $throwable){
                    /**
                     * 使用默认的
                     */
                    throw $exception;
                }
            }
        }
    }

    /**
     * 自定义请求
     * @throws \Exception
     */
    protected function onRequest()
    {
        throw new \Exception('onRequest Undefined');
    }

    /**
     * 自定义404 页面
     * @param $action
     * @throws \Exception
     */
    protected function actionNotFound($action)
    {
        throw new \Exception('actionNotFound Undefined');
    }

    /**
     * 之定义action 执行完的操作
     * @param $actionName
     * @throws \Exception
     */
    protected function afterAction($actionName)
    {
        throw new \Exception('afterAction Undefined');
    }

    /**
     * 自定义异常处理
     * @param \Throwable $throwable
     * @param $actionName
     * @throws \Exception
     */
    protected function onException(\Throwable $throwable,$actionName)
    {
        throw new \Exception('onException Undefined');
    }

}