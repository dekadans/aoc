<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day4 extends AbstractDay
{
    public function first(): string
    {
        $pairs = $this->getPairs();
        $count = 0;

        foreach ($pairs as $pair) {
            if (!array_diff($pair[0], $pair[1]) || !array_diff($pair[1], $pair[0])) {
                $count++;
            }
        }

        return (string) $count;
    }

    public function second(): string
    {
        $pairs = $this->getPairs();

        return (string) array_reduce($pairs, function ($count, $pair) {
            return $count + (array_intersect(...$pair) ? 1 : 0);
        }, 0);
    }

    private function getPairs(): array
    {
        $pairs = $this->input->table(columnSeparator: ",");

        return array_map(
            fn($p) => array_map(
                fn($elf) => range(...explode('-', $elf)),
                $p
            ),
            $pairs
        );
    }

    protected function day(): int
    {
        return 4;
    }
}