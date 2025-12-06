<?php declare(strict_types=1);

namespace AOC2025\Solutions;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('day:2', description: 'Day 2: Gift Shop')]
class Day2
{
    public function __invoke(OutputInterface $out): int
    {
        $allRepeating = $twiceRepeating = [];
        $regex = '/^([0-9]+)(\1+)$/';
        $ranges = explode(",", stream_get_contents(STDIN));

        foreach ($ranges as $r) {
            [$from, $to] = array_map(intval(...), explode('-', $r));

            for ($i = $from; $i <= $to; $i++) {
                if (preg_match($regex, (string) $i, $matches)) {
                    $allRepeating[] = $i;

                    if (strlen($matches[1]) === strlen($matches[2])) {
                        $twiceRepeating[] = $i;
                    }
                }
            }
        }

        $out->writeln("Part 1: " . array_sum($twiceRepeating));
        $out->writeln("Part 2: " . array_sum($allRepeating));

        return 0;
    }
}