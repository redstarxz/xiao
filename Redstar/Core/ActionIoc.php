<?php
namespace Redstar\Core;
class ActionIoc
{
    private $action = null;
    private static $ins = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function app(Action $action)
    {
        self::$ins = self::$ins ? self::$ins : new ActionIoc();
        self::$ins->action = $action;
        return self::$ins;
    }

    public function run()
    {
        self::$ins->beforeAction();
        self::$ins->action->execute();
        self::$ins->afterAction();
    }

    private function beforeAction()
    {
        self::$ins->action->beforeRun();
    }

    private function afterAction()
    {
        self::$ins->action->afterRun();
    }
}


