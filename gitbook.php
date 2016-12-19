<?php

include_once "vendor/autoload.php";

use diversen\conf;
//use diversen\cli;
//use diversen\cli\main as mainCli;
use diversen\minimalCli;

$path = dirname(__FILE__);
conf::setMainIni('base_path', $path); 

$cli = new minimalCli();

// $apache2 = new \diversen\commands\apache2Command();
$commands = [];
$commands['apache2'] = new \diversen\commands\apache2Command();
$commands['backup'] = new \diversen\commands\backup();
$cli->commands = $commands;

$cli->runMain();
//mainCli::init();
//$ret = mainCli::run();
//exit($ret);
