<?php

declare(strict_types=1);

namespace Proxx\Part2;

use InvalidArgumentException;
use Proxx\Part1\Cell;
use Proxx\Part1\State;

/**
 * Default php function `random_int` used to randomize black holes position.
 * Deduplication applied on setting black holes to the same cell.
 */
class InitCellsWithBlackHoles {

    private State $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function init(int $count): void {
        if ($count < 1 || $count > 30) {
            throw new InvalidArgumentException('Count should be in a range [1:30]');
        }

        $i = 0;

        while ($i < $count) {
            $currentCell = null;

            while ($currentCell === null || $currentCell->hasBlackHole()) {
                $x = random_int(0, $this->state->getWidth() - 1);
                $y = random_int(0, $this->state->getHeight() - 1);
                $currentCell = $this->state->getCell($x, $y);
            }

            $this->state->setCell($x, $y, new Cell(true));

            $i++;
        }
    }
}