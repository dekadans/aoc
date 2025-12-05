<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day7 extends AbstractDay
{
    public function first(): string
    {
        $sizes = $this->getSizes();
        return (string) array_sum(array_filter($sizes, fn($d) => $d <= 100000));
    }

    public function second(): string
    {
        $sizes = $this->getSizes();
        $totalSize = $sizes[md5('/')];
        $lacking = 30000000 - (70000000 - $totalSize);

        $sizes = array_filter($sizes, fn($s) => $s >= $lacking);
        asort($sizes);

        return (string) array_shift($sizes);
    }

    private function getSizes(): array
    {
        $cli = $this->input->rows();

        $path = [];
        $dirSize = [];
        $matches = [];

        foreach ($cli as $cmd) {
            if ($cmd === '$ cd ..') {
                array_pop($path);
            } else if (preg_match('/^\$ cd ([a-z\/]+)/', $cmd, $matches)) {
                $id = md5(implode("", $path) . $matches[1]);
                $path[] = $id;
            } else if (preg_match('/^(\d+) /', $cmd, $matches)) {
                foreach ($path as $dir) {
                    if (!isset($dirSize[$dir])) {
                        $dirSize[$dir] = $matches[1];
                    } else {
                        $dirSize[$dir] += $matches[1];
                    }
                }
            }
        }

        return $dirSize;
    }

    protected function day(): int
    {
        return 7;
    }
}