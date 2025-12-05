<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day1 extends AbstractDay
{
    private function elfCalories(): array
    {
        return array_map(function ($items) {
            return array_sum($items);
        }, $this->input->grouped());
    }

    public function first(): string
    {
        return (string) max($this->elfCalories());
    }

    public function second(): string
    {
        $elves = $this->elfCalories();
        rsort($elves);

        return (string) array_sum(array_slice($elves, 0, 3));
    }

    protected function day(): int
    {
        return 1;
    }
}