<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day8 extends AbstractDay
{
    private array $trees;
    private int $rows;
    private int $columns;

    protected function init()
    {
        $this->trees = array_map(str_split(...), $this->input->rows());
        $this->rows = count($this->trees);
        $this->columns = count($this->trees[0]);
    }

    public function first(): string
    {
        $outer = $this->rows * 2 + $this->columns * 2 - 4;

        $visible = array_filter($this->traverseInnerTrees(function ($height, $los) {
            foreach ($los as $l) {
                if (max($l) < $height) {
                    return true;
                }
            }
            return false;
        }));

        return (string) ($outer + count($visible));
    }

    public function second(): string
    {
        $scores = $this->traverseInnerTrees(function ($height, $los) {
            $d = [];
            foreach ($los as $direction) {
                $view = 0;
                foreach ($direction as $currentHeight) {
                    $view++;
                    if ($currentHeight >= $height) {
                        break;
                    }
                }
                $d[] = $view;
            }
            return array_reduce($d, fn($a, $b) => $a * $b, 1);
        });

        return (string) max($scores);
    }

    private function traverseInnerTrees(callable $reduce): array
    {
        $r = range(1, $this->rows - 2);
        $c = range(1, $this->columns - 2);
        $result = [];

        foreach ($c as $i) {
            foreach ($r as $j) {
                $tree = [$i, $j];
                $height = $this->trees[$j][$i];

                $los = $this->getLineOfSight(...$tree);

                $result[] = $reduce($height, $los);
            }
        }

        return $result;
    }

    private function getLineOfSight(int $x, int $y): array
    {
        $trees = [
            'above' => [],
            'below' => [],
            'left' => [],
            'right' => []
        ];

        $above = range(0, $y - 1);
        foreach ($above as $yy) {
            $trees['above'][] = $this->trees[$yy][$x];
        }
        $trees['above'] = array_reverse($trees['above']);

        $below = range($y + 1, $this->rows - 1);
        foreach ($below as $yy) {
            $trees['below'][] = $this->trees[$yy][$x];
        }


        $left = range(0, $x - 1);
        foreach ($left as $xx) {
            $trees['left'][] = $this->trees[$y][$xx];
        }
        $trees['left'] = array_reverse($trees['left']);


        $right = range($x + 1, $this->columns - 1);
        foreach ($right as $xx) {
            $trees['right'][] = $this->trees[$y][$xx];
        }

        return $trees;
    }

    protected function day(): int
    {
        return 8;
    }
}