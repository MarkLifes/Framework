<?php
namespace Itxiao6\Framework\Component;
/**
 * 接管异常类
 * Class Hash
 * @package Itxiao6\Framework\Component
 */
class Hash {
    /**
     * 加密
     * @param $str
     * @param int $algo
     * @return bool|string
     */
    public static function make($str,$algo = PASSWORD_DEFAULT){
        return password_hash($str,$algo);
    }

    /**
     * 验证是否正确
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function check($password,$hash){
        return password_verify($password,$hash);
    }
}