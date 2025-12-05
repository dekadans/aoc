<?php

namespace Advent\Common\Days;

use Advent\Common\Input\Input;
use Advent\Common\Input\InputHandlerInterface;

abstract class AbstractDay implements DayInterface
{
    abstract protected function day(): int;

    protected Input $input;

    public function __construct(
        InputHandlerInterface $inputHandler,
        private readonly bool $isDebugging = false
    ) {
        $this->input = new Input($inputHandler, $this->day());
        $this->init();
    }

    protected function init()
    {

    }

    protected function debug($data): void
    {
        if (!$this->isDebugging) return;

        if (is_string($data)) {
            echo "$data\n";
        } else {
            print_r($data);
        }
    }
}