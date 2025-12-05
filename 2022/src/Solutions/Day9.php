<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day9 extends AbstractDay
{
    private array $instructions;
    private array $uniqueTailLocations = [];
    private array $knots = [];

    protected function init()
    {
        $this->instructions = array_merge(...array_map(
            fn($inst) => array_fill(0, (int) $inst[1], $inst[0]),
            $this->input->table()
        ));
    }

    public function first(): string
    {
        $this->initiateKnots(2);
        return $this->run();
    }

    public function second(): string
    {
        $this->initiateKnots(10);
        return $this->run();
    }

    private function initiateKnots(int $num)
    {
        $this->knots = array_fill(0, $num, [0, 0]);
    }

    private function run(): string
    {
        $length = count($this->knots);

        foreach ($this->instructions as $i) {
            $this->moveHead($i);
            for ($k = 1; $k < $length; $k++) {
                $this->moveKnot($k);
            }
            $this->storeTailLocation();
        }

        return (string) count($this->uniqueTailLocations);
    }

    private function moveHead(string $direction)
    {
        $head = &$this->knots[0];

        switch ($direction) {
            case 'L':
                $head[0]--;
                break;
            case 'U':
                $head[1]++;
                break;
            case 'R':
                $head[0]++;
                break;
            case 'D':
                $head[1]--;
                break;
        }
    }

    private function moveKnot(int $k)
    {
        $knot = &$this->knots[$k];
        $following = &$this->knots[$k-1];

        $diffX = $following[0] - $knot[0];
        $diffY = $following[1] - $knot[1];

        $stepsX = abs($diffX);
        $stepsY = abs($diffY);

        if ($stepsX < 2 && $stepsY < 2) {
            return;
        }

        $moveX = 0;
        $moveY = 0;

        if ($stepsX === 2) {
            $moveX = $this->mv($diffX);

            if ($stepsY === 1) {
                $moveY = $this->mv($diffY);
            }
        }

        if ($stepsY === 2) {
            $moveY = $this->mv($diffY);

            if ($stepsX === 1) {
                $moveX = $this->mv($diffX);
            }
        }

        $knot[0] += $moveX;
        $knot[1] += $moveY;
    }

    private function mv(int $value): int
    {
        return $value > 0 ? 1 : -1;
    }

    private function storeTailLocation()
    {
        $tail = $this->knots[count($this->knots)-1];

        $hash = md5($tail[0] . ',' . $tail[1]);
        if (!in_array($hash, $this->uniqueTailLocations)){
            $this->uniqueTailLocations[] = $hash;
        }
    }

    protected function day(): int
    {
        return 9;
    }
}