<?php

namespace App\Solutions;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('day:1', description: 'Day 1: Secret Entrance')]
class Day1
{
    public function __invoke(OutputInterface $out): int
    {
        $val = 50;
        $first = $second = 0;
        $input = explode("\n", stream_get_contents(STDIN));

        foreach ($input as $instruction) {
            $step = $instruction[0] === 'L' ? -1 : 1;
            $amount = (int) substr($instruction, 1);

            for ($i = 0; $i < $amount; $i++) {
                $val = ($val + $step) % 100;
                if ($val === 0) {
                    $second++;
                }
            }

            if ($val === 0) {
                $first++;
            }
        }

        $out->writeln("Part 1: $first");
        $out->writeln("Part 2: $second");

        return 0;
    }
}