<?php
declare(strict_types=1);

namespace Advent\Solutions;

use Advent\Common\Days\AbstractDay;

class Day2 extends AbstractDay
{
    public function first(): string
    {
        $myAction = function(string $input, string $opponent) {
            return match ($input) {
                'X' => 'A',
                'Y' => 'B',
                'Z' => 'C'
            };
        };

        return (string) $this->run($myAction);
    }

    public function second(): string
    {
        $myAction = function(string $input, string $opponent) {
            return match ($input) {
                'X' => Game::$winnerMap[$opponent],  // lose
                'Y' => $opponent,  // draw
                'Z' => array_flip(Game::$winnerMap)[$opponent],  // win
            };
        };

        return (string) $this->run($myAction);
    }

    private function run(\Closure $myAction): int
    {
        return array_sum(
            array_map(
                fn($g) => (new Game($g, $myAction))->score(),
                $this->input->table()
            )
        );
    }

    protected function day(): int
    {
        return 2;
    }
}

class Game
{
    private string $opponent;
    private string $me;

    public static array $winnerMap = [
        'A' => 'C',
        'B' => 'A',
        'C' => 'B',
    ];

    public function __construct(array $round, \Closure $myAction)
    {
        $this->opponent = $round[0];
        $this->me = $myAction($round[1], $this->opponent);
    }

    public function score(): int
    {
        return $this->choiceScore() + $this->resultScore();
    }

    private function choiceScore(): int
    {
        return match ($this->me) {
            'A' => 1,
            'B' => 2,
            'C' => 3
        };
    }

    private function resultScore(): int
    {
        return match ($this->result()) {
            -1 => 0,
            0 => 3,
            1 => 6
        };
    }

    /**
     * 1 for I win, 0 for draw, -1 for opponent win
     * @return int
     */
    private function result(): int
    {
        if ($this->opponent === $this->me) {
            return 0;
        }

        if (self::$winnerMap[$this->me] === $this->opponent) {
            return 1;
        }

        return -1;
    }
}