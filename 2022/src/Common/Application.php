<?php

namespace Advent\Common;

use Advent\Common\Days\AbstractDay;
use Advent\Common\Input\FileInputHandler;
use Advent\Common\Input\InputHandlerInterface;

class Application implements ApplicationInterface
{
    /**@var string[] */
    private array $arguments;
    private InputHandlerInterface $inputHandler;

    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
        $this->inputHandler = new FileInputHandler(__DIR__ . "/../../inputs");
    }

    public function solve(): string
    {
        $this->validate();
        $solver = $this->getSolver();
        return $solver();
    }

    private function validate(): void
    {
        if (count($this->arguments) < 3) {
            throw new \RuntimeException('Invalid number of arguments');
        }

        if ($this->getDay() < 1) {
            throw new \RuntimeException('Invalid requested day!');
        }

        if ($this->getPart() < 1 || $this->getPart() > 2) {
            throw new \RuntimeException('Invalid requested solution part!');
        }
    }

    private function getDay(): int
    {
        return intval($this->arguments[1] ?? "0");
    }

    private function getPart(): int
    {
        return intval($this->arguments[2] ?? "0");
    }

    private function isDebug(): bool
    {
        return in_array('-v', $this->arguments);
    }

    private function getSolver(): \Closure
    {
        $day = $this->getDay();
        $class = "\\Advent\\Solutions\\Day{$day}";

        if (!class_exists($class)) {
            throw new \RuntimeException("Day number {$day} is not attempted yet!");
        }

        /** @var AbstractDay $solution */
        $solution = new $class($this->inputHandler, $this->isDebug());

        return match ($this->getPart()) {
            1 => $solution->first(...),
            2 => $solution->second(...),
            default => throw new \RuntimeException("Unknown part to solve")
        };
    }
}