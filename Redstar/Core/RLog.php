<?php
namespace Redstar\Core;
class RLog
{
    private static $rec = array();
    private static $ins = null;

    public static function getInstance()
    {
        if (!self::$ins) {
            return new RLog();
        }
        return self::$ins;
    }

    public function addLog($key, $value)
    {
        if (!isset(self::$rec[$key])) {
            self::$rec[$key] = $value;
        }
    }

    public function setLog($key, $value)
    {
        self::$rec[$key] = $value;
    }

    public function write_file($filename, $mode = 'a')
    {
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $handle = fopen($filename, $mode);
        flock($handle, LOCK_EX);
        $date = '['.date('Y-m-d H:i:s', TIMESTAMP).'] ';
        $data = json_encode(self::$rec);
        fwrite($handle, $date.$data."\n");     
        fclose($handle);        
    }

}
