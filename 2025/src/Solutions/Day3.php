<?php declare(strict_types=1);

namespace AOC2025\Solutions;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('day:3', description: 'Day 3: Lobby')]
class Day3
{
    public function __invoke(OutputInterface $out): int
    {
        $part1 = $part2 = [];
        $banks = explode("\n", stream_get_contents(STDIN));

        foreach ($banks as $b) {
            $batteries = array_map(intval(...), str_split($b));

            $part1[] = $this->findForLength($batteries, 2);
            $part2[] = $this->findForLength($batteries, 12);
        }

        $out->writeln('Part 1: ' . array_sum($part1));
        $out->writeln('Part 2: ' . array_sum($part2));

        return 0;
    }

    private function findForLength(array $batteries, int $length): int
    {
        $batteryString = '';
        $fromStart = 0;

        for ($i = 0; $i < $length; $i++) {
            $fromEnd = ($i - $length + 1) ?: null;

            $possibleBatteries = array_slice($batteries, $fromStart, $fromEnd);
            $foundIndex = $fromStart + array_search(max($possibleBatteries), $possibleBatteries);
            $batteryString .= $batteries[$foundIndex];

            $fromStart = $foundIndex+1;
        }

        return (int) $batteryString;
    }
}