<?php declare(strict_types=1);

namespace App\Solutions;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('day:5', description: 'Day 5: Cafeteria')]
class Day5
{
    public function __invoke(OutputInterface $out): int
    {
        $parts = explode("\n\n", stream_get_contents(STDIN));
        $ranges = array_map(
            fn($r) => array_map(intval(...), explode("-", $r)),
            explode("\n", $parts[0])
        );
        $ingredients = array_map(intval(...), explode("\n", $parts[1]));
        $part1 = $part2 = [];

        // Sort and normalize

        usort($ranges, fn ($a, $b) => $a[0] <=> $b[0]);
        do {
            for ($i = 0; $i < count($ranges)-1; $i++) {
                if ($ranges[$i][1] >= $ranges[$i+1][0]) {
                    $ranges[$i+1][0] = $ranges[$i][1]+1;
                }
            }

            $unfilteredCount = count($ranges);
            $ranges = array_values(array_filter($ranges, fn ($r) => $r[0] <= $r[1]));
        } while ($unfilteredCount !== count($ranges));

        // Part 1

        foreach ($ingredients as $ingredient) {
            foreach ($ranges as [$from, $to]) {
                if ($ingredient >= $from && $ingredient <= $to) {
                    $part1[] = $ingredient;
                    continue 2;
                }
            }
        }

        // Part 2

        foreach ($ranges as [$from, $to]) {
            $part2[] = $to - $from + 1;
        }

        $out->writeln('Part 1: ' . count($part1));
        $out->writeln('Part 2: ' . array_sum($part2));

        return 0;
    }
}