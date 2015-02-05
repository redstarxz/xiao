<?php
require 'Redstar/init.php';
echo APP_NAME, ' ';
$a = new \Redstar\App\Service\Test();
echo $a->say();
