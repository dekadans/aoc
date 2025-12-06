<?php
/*
 * Run the solution for a given day and part
 * php advent.php [day] [part]
 *
 * E.g. "php advent.php 2 1"
 * runs the first part of the December 2nd puzzle
 */

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Advent\Common\Application($argv);

try {
    $answer = $app->solve();
    if (empty($answer)) {
        echo "This day is a work in progress!\n";
    } else {
        echo "The answer is: {$answer}\n";
    }
} catch (RuntimeException $e) {
    echo $e->getMessage() . PHP_EOL;
    die;
}


