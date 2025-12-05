<?php

namespace Advent\Common\Input;

class Input
{
    private InputHandlerInterface $loader;
    private int $day;

    public function __construct(InputHandlerInterface $loader, int $day)
    {
        $this->loader = $loader;
        $this->day = $day;
    }

    public function all(): string
    {
        return $this->loader->loadForDay($this->day);
    }

    public function rows(string $rowSeparator = "\n"): array
    {
        return explode($rowSeparator, $this->all());
    }

    public function grouped(string $groupSeparator = "\n\n", string $rowSeparator = "\n"): array
    {
        return array_map(
            fn($g) => explode($rowSeparator, $g),
            explode($groupSeparator, $this->all())
        );
    }

    public function table(string $rowSeparator = "\n", string $columnSeparator = " "): array
    {
        return array_map(
            fn($g) => explode($columnSeparator, $g),
            explode($rowSeparator, $this->all())
        );
    }
}