<?php
namespace Redstar\Core;
class Conf
{
    private static $ins = array();
    public static function getConf($name)
    {
        if (!isset(self::$ins[$name])) {
            self::loadConf($name);
        }
        return self::$ins[$name];
    }

    private static function loadConf($name)
    {
        $app_conf = ROOT_DIR.'/../local_conf/'.APP_NAME.'/'.$name.'.php';
        $root_conf = ROOT_DIR.'/../local_conf/'.$name.'.php';
        $app_common_conf = __DIR__.'/../conf/'.$name.'.php';

        if(file_exists($app_conf)) {
            self::$ins[$name] = include $app_conf;
        } else if (file_exists($root_conf)) {
            self::$ins[$name] = include $root_conf;
        } else if (file_exists($app_common_conf)) {
            self::$ins[$name] = include $app_common_conf;
        } else {
            throw new \Exception('no app conf find!');
        }
    }

}
