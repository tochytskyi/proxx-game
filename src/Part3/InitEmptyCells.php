<?php

declare(strict_types=1);

namespace Proxx\Part3;

use Proxx\Part1\Cell;
use Proxx\Part1\State;

/**
 * To update a cell with adjacent black holes count we use iterations for each one
 * where all adjacent cells will be checked one by one.
 */
class InitEmptyCells {

    private State $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function init(): void {

        foreach (range(0, $this->state->getWidth() - 1) as $x) {
            foreach (range(0, $this->state->getHeight() - 1) as $y) {
                $cell = $this->state->getCell($x, $y);

                if ($cell->hasBlackHole()) {
                    continue;
                }

                $this->updateCellAdjacentBlackHolesCount($x, $y);
            }
        }
    }

    private function updateCellAdjacentBlackHolesCount(int $x, int $y): void
    {
        $blackHolesCount = 0;

        for ($i = -1; $i < 2; $i++) {
            for ($j = -1; $j < 2; $j++) {

                //current cell, skip
                if ($i === 0 && $j === 0) {
                    continue;
                }

                $adjacentX = $x + $i;
                $adjacentY = $y + $j;

                //non-existing cell, skip
                if ($adjacentX < 0 || $adjacentY < 0) {
                    continue;
                }

                //non-existing cell, skip
                if ($adjacentX > ($this->state->getWidth() - 1) || $adjacentY > ($this->state->getHeight() - 1)) {
                    continue;
                }

                if ($this->state->isCellWithBlackHole($adjacentX, $adjacentY)) {
                    $blackHolesCount++;
                }
            }
        }

        if ($blackHolesCount < 1) {
            return;
        }

        $newCell = new Cell();
        $newCell->setAdjacentBlackHolesCount($blackHolesCount);
        $this->state->setCell($x, $y, $newCell);
    }
}