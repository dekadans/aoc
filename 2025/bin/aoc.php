<?php

use Symfony\Component\Console\Application;

require_once __DIR__ . '/../../vendor/autoload.php';

$app = new Application('Advent of Code');

$app->addCommands([
    new \AOC2025\Solutions\Day1(),
    new \AOC2025\Solutions\Day2(),
    new \AOC2025\Solutions\Day3(),
    new \AOC2025\Solutions\Day4(),
    new \AOC2025\Solutions\Day5(),
    new \AOC2025\Solutions\Day6()
]);

$app->run();