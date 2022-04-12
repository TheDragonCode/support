<?php

use DragonCode\SupportDev\Console\GenerateCommand;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$application = new Application('The Dragon Code: Docs Generator');

$application->add(new GenerateCommand());

$application->run();
