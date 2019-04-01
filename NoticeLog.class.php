<?php

namespace lib;

/**
 * NoticeLogClass
 * User: xuexiaoyang
 * Date: 2018/7/3
 * Time: 17:58
 */
/**
 * -----------------------------------接口优化辅助日志-----------------------------------
 * 记录接口耗时，可以在同等日志按天为单位
 * 记录地址：code/framework/logs/Notice/
 *
 *
 */

class NoticeLog
{
    private static $startName = [];
    private static $endName   = [];
    public static function start(string $star_name)
    {
        if (empty($star_name)) {
            return false;
        }
        $data[$star_name] = self::_getTime();
        self::$startName  = array_merge(self::$startName, $data);
    }
    public static function stop(string $end_name)
    {
       if (empty($end_name)) {
           return false;
       }
        $data[$end_name] = self::_getTime();
        self::$endName = array_merge(self::$endName, $data);
    }
    private static function _getTime()
    {
        list($msec, $sec) = explode(' ', microtime());
        $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        return $msectime;

    }
    public static function run()
    {
        if (empty(self::$startName)) {
            return false;
        }
        $endData = self::$endName;
        $str = '[http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'] performance:';
        foreach (self::$startName as $k => $v) {
            if (isset($endData[$k])) {
                $vv   = $endData[$k];
                $str .= '['.$k.'：'.ceil($vv-$v). 'ms] ';
            }
        } 
        runtime_log("Notice/optimize", $str);
    }

}