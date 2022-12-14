<?php

declare(strict_types=1);

namespace Proxx\Part4;

use Proxx\Part1\State;

/**
 * If a cell is opened we will check all adjacent cells.
 * Then open recursively each one with 0 adjacent black holes.
 */
class OpenCell {

    private State $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function open(int $x, int $y): void
    {
        $cell = $this->state->getCell($x, $y);

        if ($cell->isOpened()) {
            return;
        }

        $cell->open();
        $this->state->setCell($x, $y, $cell);

        if ($cell->hasBlackHole()) {
            throw new CellWithBlackHoleOpenedException($x, $y);
        }

        for ($i = -1; $i < 2; $i++) {
            for ($j = -1; $j < 2; $j++) {

                //current cell, skip
                if ($i === 0 && $j === 0) {
                    continue;
                }

                $adjacentX = $x + $i;
                $adjacentY = $y + $j;

                if ($this->checkIfNonExistingCell($adjacentX, $adjacentY)) {
                    continue;
                }

                $adjacentCell = $this->state->getCell($adjacentX, $adjacentY);

                //continue open cells that have 0 adjacent cells with black holes
                if (!$adjacentCell->isOpened() && !$adjacentCell->hasBlackHole() && $adjacentCell->getAdjacentBlackHolesCount() === 0) {
                    $this->open($adjacentX, $adjacentY);
                }

                if (!$adjacentCell->isOpened() && !$adjacentCell->hasBlackHole()) {
                    $adjacentCell->open();
                    $this->state->setCell($adjacentX, $adjacentY, $adjacentCell);
                }
            }
        }
    }

    private function checkIfNonExistingCell(int $adjacentX, int $adjacentY): bool
    {
        if ($adjacentX < 0 || $adjacentY < 0) {
            return true;
        }

        if ($adjacentX > ($this->state->getWidth() - 1) || $adjacentY > ($this->state->getHeight() - 1)) {
            return true;
        }

        return false;
    }
}