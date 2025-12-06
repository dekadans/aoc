<?php declare(strict_types=1);

namespace AOC2025\Solutions;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('day:4', description: 'Day 4: Printing Department')]
class Day4
{
    public function __invoke(
        OutputInterface $out,
        #[Option] bool $csv = false
    ): int {
        $iterations = [];
        $grid = array_map(
            str_split(...),
            explode("\n", stream_get_contents(STDIN))
        );
        $adjacent = [
            [-1, -1],   [-1, 0],    [-1, 1],
            [0, -1],                [0, 1],
            [1, -1],    [1, 0],     [1, 1]
        ];

        do {
            $accessed = [];
            for ($y = 0; $y < count($grid); $y++) {
                for ($x = 0; $x < count($grid[$y]); $x++) {
                    if ($grid[$y][$x] !== '@') {
                        continue;
                    }

                    $neighbors = 0;
                    foreach ($adjacent as [$dy, $dx]) {
                        if (($grid[$y+$dy][$x+$dx] ?? null) === '@') {
                            $neighbors++;
                        }
                    }

                    if ($neighbors < 4) {
                        $accessed[] = [$y, $x];
                    }
                }
            }

            foreach ($accessed as [$y, $x]) {
                $grid[$y][$x] = '.';
            }

            $iterations[] = $accessed;
        } while (count($accessed) > 0);

        $counts = array_map(count(...), $iterations);

        if ($csv) {
            foreach ($counts as $i => $r) {
                $out->writeln("$i,$r");
            }
        } else {
            $out->writeln('Part 1: ' . $counts[0]);
            $out->writeln('Part 2: ' . array_sum($counts));
        }

        return 0;
    }
}