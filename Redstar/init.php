<?php
use Redstar\Core\Action;
use Analog\Analog;
use Analog\Handler\File;

date_default_timezone_set('Etc/GMT-8');

// vender lib autoload
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/SplClassLoader.php';

// self lib autoload
$classLoader = new SplClassLoader('Redstar', __DIR__.'/../');
$classLoader->register();

define('ROOT_DIR', dirname((dirname(__FILE__))));
define('APP_NAME', substr(strrchr(rtrim(ROOT_DIR, DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR), 1));
define('TIMESTAMP', time());

$globalConfig = \Redstar\Core\Conf::getConf('global');
foreach($globalConfig as $k => $v) {
    define(strtoupper($k), $v);
}

// error handler
/*
set_error_handler(function($code, $message, $file, $line) {
   if ( 0 == error_reporting()) {
       return;
   }
   throw new \ErrorException($message, 0, $code, $file, $line);
});
*/

// final exception catch
set_exception_handler(function (\Exception $e) {
    $status = $e->getCode()? $e->getCode(): -8;
    
    // clear when > 10M
    if (filesize(APP_LOG_FILE) > 10 * 1024 * 1024) {
        file_put_contents(APP_LOG_FILE, '');
    }
    Analog::debug('file:' . $e->getFile() . ' error line:' . $e->getLine() .
             ' msg:' . $e->getMessage());
    Action::returnData($status, $e->getMessage(), null, 'json');
    exit();
});

// log init
Analog::handler(File::init(APP_LOG_FILE));