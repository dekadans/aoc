<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day11 extends AbstractDay
{
    private array $monkeys;

    protected function init()
    {
        $this->monkeys = [
            [
                'items' => [65, 58, 93, 57, 66],
                'operation' => fn($x) => $x * 7,
                'test' => fn($x) => $x % 19 === 0 ? 6 : 4,
                'inspections' => 0
            ],
            [
                'items' => [76, 97, 58, 72, 57, 92, 82],
                'operation' => fn($x) => $x + 4,
                'test' => fn($x) => $x % 3 === 0 ? 7 : 5,
                'inspections' => 0
            ],
            [
                'items' => [90, 89, 96],
                'operation' => fn($x) => $x * 5,
                'test' => fn($x) => $x % 13 === 0 ? 5 : 1,
                'inspections' => 0
            ],
            [
                'items' => [72, 63, 72, 99],
                'operation' => fn($x) => $x * $x,
                'test' => fn($x) => $x % 17 === 0 ? 0 : 4,
                'inspections' => 0
            ],
            [
                'items' => [65],
                'operation' => fn($x) => $x + 1,
                'test' => fn($x) => $x % 2 === 0 ? 6 : 2,
                'inspections' => 0
            ],
            [
                'items' => [97, 71],
                'operation' => fn($x) => $x + 8,
                'test' => fn($x) => $x % 11 === 0 ? 7 : 3,
                'inspections' => 0
            ],
            [
                'items' => [83, 68, 88, 55, 87, 67],
                'operation' => fn($x) => $x + 2,
                'test' => fn($x) => $x % 5 === 0 ? 2 : 1,
                'inspections' => 0
            ],
            [
                'items' => [64, 81, 50, 96, 82, 53, 62, 92],
                'operation' => fn($x) => $x + 5,
                'test' => fn($x) => $x % 7 === 0 ? 3 : 0,
                'inspections' => 0
            ],
        ];
    }

    public function first(): string
    {
        for ($round = 0; $round < 20; $round++) {
            for ($monkey = 0; $monkey < count($this->monkeys); $monkey++) {
                $numItems = count($this->monkeys[$monkey]['items']);
                for ($i = 0; $i < $numItems; $i++) {
                    $this->monkeys[$monkey]['inspections']++;
                    $item = array_shift($this->monkeys[$monkey]['items']);
                    $item = $this->monkeys[$monkey]['operation']($item);
                    $item = floor($item / 3);
                    $to = $this->monkeys[$monkey]['test']($item);
                    $this->monkeys[$to]['items'][] = $item;
                }
            }
        }

        $inspections = array_map(fn($m) => $m['inspections'], $this->monkeys);
        rsort($inspections);

        return (string) ($inspections[0] * $inspections[1]);
    }

    public function second(): string
    {
        return "";
    }

    protected function day(): int
    {
        return 11;
    }
}