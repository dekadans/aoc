<?php declare(strict_types=1);

namespace AOC2025\Solutions;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('day:7', description: 'Day 7: Laboratories')]
class Day7
{
    public function __invoke(OutputInterface $out): int
    {
        $diagram = array_map(
            str_split(...),
            explode("\n", stream_get_contents(STDIN))
        );

        $start = array_search('S', $diagram[0]);
        $beams = [$start];
        $timelines = array_fill(0, count($diagram[0]), 0);
        $timelines[$start]++;
        $splits = 0;

        for ($i = 2; $i < count($diagram); $i += 2) {
            $splitters = array_keys($diagram[$i], '^');
            $hit = array_intersect($splitters, $beams);
            $miss = array_diff($beams, $splitters);

            $newBeams = [];
            foreach ($hit as $splitter) {
                $splits++;
                $left = $splitter-1;
                $right = $splitter+1;
                array_push($newBeams, $left, $right);

                $timelines[$left] += $timelines[$splitter];
                $timelines[$right] += $timelines[$splitter];
                $timelines[$splitter] = 0;
            }

            $beams = array_values(array_unique(array_merge($newBeams, $miss)));
        }

        $out->writeln('Part 1: ' . $splits);
        $out->writeln('Part 2: ' . array_sum($timelines));

        return 0;
    }

}