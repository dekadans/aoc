<?php

/*
 * Script to bootstrap a new day:
 * php init.php [day]
 */

$dayToCreate = intval($argv[1] ?? "0");

if ($dayToCreate < 1) {
    echo "Invalid day integer\n";
    die;
}

$phpFile = __DIR__ . "/src/Solutions/Day{$dayToCreate}.php";
$inputFile = __DIR__ . "/input/{$dayToCreate}.txt";

if (file_exists($phpFile)) {
    echo "Solution attempt already exists for day {$dayToCreate}, skipping\n";
} else {
    file_put_contents($phpFile, <<<PHP
<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day{$dayToCreate} extends AbstractDay
{
    public function first(): string
    {
        return "";
    }

    public function second(): string
    {
        return "";
    }

    protected function day(): int
    {
        return {$dayToCreate};
    }
}
PHP
);
    echo "Created solution attempt.\n";
}

if (file_exists($inputFile)) {
    echo "Input data already exists for day {$dayToCreate}, skipping\n";
} else {
    file_put_contents($inputFile, "");
    echo "Created empty input file.\n";
}