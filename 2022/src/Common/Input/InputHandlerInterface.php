<?php

namespace Advent\Common\Input;

interface InputHandlerInterface
{
    public function loadForDay(int $day): string;
}