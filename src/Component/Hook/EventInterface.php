<?php
namespace Itxiao6\Framework\AbstractInterface;
use Itxiao6\Database\Capsule\Manager;
use Itxiao6\Session\Session;
use Itxiao6\Framework\Component\DB;

/**
 * 系统事件
 * Interface Event
 * @package Itxiao6\Framework\AbstractInterface
 */
interface Event
{
    /**
     * web 路由入口
     * @param $appName
     * @param $controllerName
     * @param $actionName
     * @param $request
     * @param $response
     * @param $session
     */
    public static function http_route($appName,$controllerName,$actionName,$request,$response,$session);

    /**
     * 获取会话
     * @param $request
     * @param $response
     * @return mixed
     * @throws \Exception
     */
    public static function session($request,$response);

    /**
     * 数据库连接
     */
    public static function databases_connection();

    /**
     * 获取数据库连接状态
     * @return bool
     */
    public static function get_databases_status();

}