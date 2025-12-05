<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day6 extends AbstractDay
{
    public function first(): string
    {
        return (string) $this->findSequence(4);
    }

    public function second(): string
    {
        return (string) $this->findSequence(14);
    }

    private function findSequence(int $length): int
    {
        $stream = str_split($this->input->all());

        for ($i = 0; $i < count($stream); $i++) {
            $sequence = array_slice($stream, $i, $length);
            if (count(array_unique($sequence)) === $length) {
                break;
            }
        }

        return $i + $length;
    }

    protected function day(): int
    {
        return 6;
    }
}