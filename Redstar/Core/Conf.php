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
        $local_app_conf = LOCAL_APP_CONF_DIR.'/'.$name.'.php';
        $local_common_conf = LOCAL_COMMON_CONF_DIR.'/'.$name.'.php';
        $app_conf = APP_CONF_DIR.'/'.$name.'.php';

        if(file_exists($local_app_conf)) {
            self::$ins[$name] = include $local_app_conf;
        } else if (file_exists($local_common_conf)) {
            self::$ins[$name] = include $local_common_conf;
        } else if (file_exists($app_conf)) {
            self::$ins[$name] = include $app_conf;
        } else {
            throw new \Exception('no app conf find!');
        }
    }

}
