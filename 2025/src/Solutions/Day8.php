<?php declare(strict_types=1);

namespace AOC2025\Solutions;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('day:8', description: 'Day 8: Playground')]
class Day8
{
    public function __invoke(OutputInterface $out): int
    {
        $points = array_map(
            fn ($p) => array_map(
                intval(...),
                explode(',', $p)
            ),
            explode("\n", stream_get_contents(STDIN))
        );

        // Generate all combinations of two points and the distance between them.
        $combinations = [];
        for ($i = 0; $i < count($points) - 1; $i++) {
            for ($j = $i + 1; $j < count($points); $j++) {
                [$p1, $p2, $p3] = $points[$i];
                [$q1, $q2, $q3] = $points[$j];

                // Euclidean distance
                $d1 = pow($p1 - $q1, 2);
                $d2 = pow($p2 - $q2, 2);
                $d3 = pow($p3 - $q3, 2);
                $distance = round(sqrt($d1 + $d2 + $d3));

                $combinations[] = [$i, $j, $distance];
            }
        }
        // Sort by shortest distance.
        usort($combinations, fn($a, $b) => $a[2] <=> $b[2]);

        $circuits = [];
        $part1 = null;
        $part2 = null;

        for ($c = 0; $c < count($combinations); $c++) {
            // Grab the (indices of) two points in this combination.
            [$i1, $i2] = $combinations[$c];
            // Find the points in existing circuits.
            $i1c = array_find_key($circuits, fn ($v) => in_array($i1, $v));
            $i2c = array_find_key($circuits, fn ($v) => in_array($i2, $v));

            if ($i1c === null && $i2c === null) {
                // Neither point is in a circuit, create a new.
                $circuits[] = [$i1, $i2];
            } else if ($i1c === $i2c) {
                // Both points are in the same circuit, no change.
            } else if ($i1c === null) {
                // Point 1 is not in a circuit, add it to Point 2's circuit.
                $circuits[$i2c][] = $i1;
            } else if ($i2c === null) {
                // Point 2 is not in a circuit, add it to Point 1's circuit.
                $circuits[$i1c][] = $i2;
            } else {
                // Both points are in different circuits, merge them into one.
                $circuits[$i1c] = array_merge($circuits[$i1c], $circuits[$i2c]);
                unset($circuits[$i2c]);
            }

            if ($c == 1000) {
                // Part 1 calculation after 1000 combinations processed.
                $partialCircuits = array_map(count(...), $circuits);
                rsort($partialCircuits);
                $part1 = array_product(array_slice($partialCircuits, 0, 3));
            }

            if (count($circuits) === 1 && count(array_first($circuits)) == count($points)) {
                // Part 2 calculation when all points are in one big circuit.
                $part2 = $points[$i1][0] * $points[$i2][0];
                break;
            }
        }

        $out->writeln('Part 1: ' . $part1);
        $out->writeln('Part 2: ' . $part2);
        return 0;
    }
}