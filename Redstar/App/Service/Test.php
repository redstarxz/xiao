<?php
namespace Redstar\App\Service;
class Test
{
    public function say()
    {
        echo 'service:  ';
        $m = new \Redstar\App\Model\Test();
        echo $m->say();
    }

}
