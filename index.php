<?php

require __DIR__ . '/vendor/autoload.php';

//use Castor\App;
//
//App::run();

use Castor\Commands\PrepareDataForDatabase;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new PrepareDataForDatabase());

$application->run();