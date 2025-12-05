<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day10 extends AbstractDay
{
    private int $x = 1;
    private bool $running = true;
    private array $program = [];
    private int $pointer = 0;
    private int $cycle = 0;
    private int $busy = 1;
    private ?int $queue = null;

    protected function init()
    {
        $this->program = $this->input->rows();
    }

    public function first(): string
    {
        $memory = [];

        $this->run(function () use (&$memory) {
            $sub = [20, 60, 100, 140, 180, 220];
            if (in_array($this->cycle, $sub)) {
                $memory[] = $this->cycle * $this->x;
            }
        });

        return (string) array_sum($memory);
    }

    public function second(): string
    {
        $output = '';
        $screenWidth = 40;

        $this->run(function () use (&$output, $screenWidth) {
            $pixel = in_array($this->cycle % $screenWidth, range($this->x, $this->x+2));
            $output .= ($pixel ? '#' : ' ');
        });

        return PHP_EOL . chunk_split($output, $screenWidth);
    }

    private function run(callable $subscriber): void
    {
        while ($this->isRunning()) {

            if ($this->isIdle()) {
                $this->update();

                $op = $this->readInstruction();

                if ($op === null) {
                    $this->stop();
                } elseif ($op === 'noop') {
                    $this->process(null);
                } elseif (str_contains($op, 'addx')) {
                    [, $val] = explode(' ', $op);
                    $this->process((int) $val);
                }
            }

            $subscriber();
        }
    }

    private function isRunning(): bool
    {
        $this->cycle++;
        $this->busy--;
        return $this->running;
    }

    private function stop(): void
    {
        $this->running = false;
    }

    private function isIdle(): bool
    {
        return !$this->busy;
    }

    private function readInstruction(): ?string
    {
        $op = $this->program[$this->pointer] ?? null;
        $this->pointer++;
        return $op;
    }

    private function process(?int $value): void
    {
        $this->queue = $value;
        $this->busy = is_null($this->queue) ? 1 : 2;
    }

    private function update()
    {
        if ($this->queue) {
            $this->x += $this->queue;
            $this->queue = null;
        }
    }

    protected function day(): int
    {
        return 10;
    }
}