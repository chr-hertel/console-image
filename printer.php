<?php

declare(strict_types=1);

use App\PrinterCommand;
use Symfony\Component\Console\Application;

require_once __DIR__.'/vendor/autoload.php';

$command = new PrinterCommand();

$app = new Application('CLI Image Printer');
$app->add($command);
$app->setDefaultCommand($command->getName(), true);
$app->run();
