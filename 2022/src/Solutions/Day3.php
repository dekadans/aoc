<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day3 extends AbstractDay
{
    public function first(): string
    {
        return $this->searchAndPrioritize(array_map(
            $this->itemize(...),
            array_map(
                fn($contents) => mb_str_split($contents, mb_strlen($contents) / 2),
                $this->input->rows()
            )
        ));
    }

    public function second(): string
    {
        return $this->searchAndPrioritize(array_chunk(
            $this->itemize($this->input->rows()),
            3
        ));
    }

    private function searchAndPrioritize(array $input): string
    {
        return (string) array_sum(
            array_map(
                $this->prioritize(...),
                array_map(
                    $this->intersect(...),
                    $input
                )
            )
        );
    }

    private function itemize(array $contents): array
    {
        return array_map(mb_str_split(...), $contents);
    }

    private function intersect(array $groupsOfItems): string
    {
        return array_values(array_unique(array_intersect(...$groupsOfItems)))[0];
    }

    private function prioritize(string $item): int
    {
        $priorities = array_merge(range('a', 'z'), range('A', 'Z'));
        return array_search($item, $priorities) + 1;
    }

    protected function day(): int
    {
        return 3;
    }
}