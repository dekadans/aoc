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
        $operations = $columnMatches[0]; // E.g. ["+    ", "*  ", ...]

        $problems = []; // E.g. [ ["123 ", " 45 ", "  6 "], ... ]
        for ($i = 0; $i < count($operations); $i++) {
            $columnLength = strlen($operations[$i]);
            $col = [];

            for ($j = 0; $j < count($numberRows); $j++) {
                $col[] = substr($numberRows[$j], 0, $columnLength);
                $numberRows[$j] = substr($numberRows[$j], $columnLength);
            }
            $problems[] = $col;
        }

        $part1 = [];
        for ($i = 0; $i < count($problems); $i++) {
            $part1[] = $this->calculate($operations[$i][0], $problems[$i]);
        }

        $part2 = [];
        for ($i = 0; $i < count($problems); $i++) {
            $operation = $operations[$i][0];
            $columnLength = strlen($operations[$i]);
            $numbers = array_fill(0, $columnLength, '');

            for ($numPos = 0; $numPos < $columnLength; $numPos++) {
                for ($row = 0; $row < count($problems[$i]); $row++) {
                    $numberParts = str_split($problems[$i][$row]);
                    $numbers[$numPos] .= array_reverse($numberParts)[$numPos];
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