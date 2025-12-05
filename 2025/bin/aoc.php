<?php

use Symfony\Component\Console\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application('Advent of Code');

$app->addCommands([
    new \App\Solutions\Day1(),
    new \App\Solutions\Day2(),
    new \App\Solutions\Day3(),
    new \App\Solutions\Day4(),
    new \App\Solutions\Day5()
]);

$app->run();