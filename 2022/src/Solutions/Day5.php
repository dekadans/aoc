<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day5 extends AbstractDay
{
    public function first(): string
    {
        return $this->moveCrates(false);
    }

    public function second(): string
    {
        return $this->moveCrates(true);
    }

    private function moveCrates(bool $isCrateMover9001): string
    {
        [$stackDesc, $instructions] = $this->input->grouped();

        $stacks = $this->flipCrateStack($stackDesc);

        foreach ($instructions as $inst) {
            [$num, $from, $to] = $this->parseInstruction($inst);

            $inTransit = [];
            for ($i = 0; $i < $num; $i++) {
                $inTransit[] = array_shift($stacks[$from]);
            }

            if (!$isCrateMover9001) {
                $inTransit = array_reverse($inTransit);
            }

            array_unshift($stacks[$to], ...$inTransit);
        }

        return array_reduce($stacks, function ($s, $stack) {
            return $s . $stack[0];
        }, '');
    }
    
    /**
     * Flips
     *
     * [
     * '    [D]    ',
     * '[N] [C]    ',
     * '[Z] [M] [P]',
     * '1   2   3  '
     * ]
     *
     * into
     *
     * [['N', 'Z'], ['D', 'C', 'M'], ['P']]
     */
    private function flipCrateStack(array $stackDesc): array
    {
        $stackDesc = array_map(function ($d) {
            return str_split($d, 4);
        }, $stackDesc);

        $columnIndex = array_pop($stackDesc);

        $struct = [];

        for ($i = 0; $i < count($columnIndex); $i++) {
            foreach ($stackDesc as $stack) {
                $crate = trim($stack[$i] ?? '', ' []');

                if ($crate) {
                    $struct[$i][] = $crate;
                }
            }
        }

        return $struct;
    }

    private function parseInstruction(string $inst): array
    {
        $matches = [];
        preg_match('/move (\d+) from (\d+) to (\d+)/', $inst, $matches);
        array_shift($matches);
        $matches[1]--;
        $matches[2]--;
        return $matches;
    }

    protected function day(): int
    {
        return 5;
    }
}