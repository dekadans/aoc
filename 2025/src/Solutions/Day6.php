<?php declare(strict_types=1);

namespace AOC2025\Solutions;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('day:6', description: 'Day 6: Trash Compactor')]
class Day6
{
    public function __invoke(OutputInterface $out): int
    {
        $rows = explode("\n", stream_get_contents(STDIN));
        $numberRows = array_slice($rows, 0, -1);

        preg_match_all('/[+*]\s+/', array_last($rows), $columnMatches);
        $colDefs = $columnMatches[0]; // E.g. ["+    ", "*  "]

        $paddedCols = [];
        for ($i = 0; $i < count($colDefs); $i++) {
            $columnLength = strlen($colDefs[$i]);
            $col = [];

            for ($j = 0; $j < count($numberRows); $j++) {
                $col[] = substr($numberRows[$j], 0, $columnLength);
                $numberRows[$j] = substr($numberRows[$j], $columnLength);
            }
            $paddedCols[] = $col;
        }

        $part1 = [];
        for ($i = 0; $i < count($colDefs); $i++) {
            $operation = $colDefs[$i][0];
            $part1[] = $this->calculate($operation, $paddedCols[$i]);
        }

        $part2 = [];
        for ($i = 0; $i < count($colDefs); $i++) {
            $c = $colDefs[$i];
            $operation = $c[0];
            $numbers = array_fill(0, strlen($c), '');

            for ($k = 0; $k < strlen($c); $k++) {
                for ($j = 0; $j < count($paddedCols[$i]); $j++) {

                    $num = $paddedCols[$i][$j];

                    $numbers[$k] .= array_reverse(str_split($num))[$k];
                }

            }

            $part2[] = $this->calculate($operation, $numbers);
        }

        $out->writeln('Part 1: ' . array_sum($part1));
        $out->writeln('Part 2: ' . array_sum($part2));

        return 0;
    }

    private function calculate(string $operation, array $numbers): int
    {
        $numbers = array_filter(
            array_map(intval(...), $numbers),
            fn ($n) => $n > 0
        );
        return match ($operation) {
            '+' => array_sum($numbers),
            '*' => array_product($numbers)
        };
    }
}