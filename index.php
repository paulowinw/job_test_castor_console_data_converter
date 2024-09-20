<?php

require __DIR__ . '/vendor/autoload.php';

use Castor\Commands\PrepareDataForDatabase;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new PrepareDataForDatabase());

$application->run();