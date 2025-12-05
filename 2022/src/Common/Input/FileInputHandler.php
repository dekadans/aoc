<?php

namespace Advent\Common\Input;

class FileInputHandler implements InputHandlerInterface
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function loadForDay(int $day): string
    {
        $file = $this->path . "/{$day}.txt";

        if (!file_exists($file)) {
            throw new \RuntimeException("Could not load input for day {$day}!");
        }

        return file_get_contents($file);
    }
}