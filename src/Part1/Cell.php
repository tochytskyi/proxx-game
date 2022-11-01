<?php

declare(strict_types=1);

namespace Proxx\Part1;

class Cell {

    /**
     * Cell is closed or opened
     *
     * @var bool $opened
     */
    private bool $opened = false;

    /**
     * Counts all adjacent cells with black holes
     *
     * @var int $adjacentBlackHolesCount
     */
    private int $adjacentBlackHolesCount = 0;

    /**
     * Indicates whether a cell has a black hole to distinguish two kinds of cell.
     * Class inheritance and interfaces skipped here as cells with black holes are the same cells,
     * however should be distinguished. Do not see any reasons to oversaturate this class with inheritance
     *
     * @var bool $hasBlackHole
     */
    private bool $hasBlackHole;

    public function __construct(bool $hasBlackHole = false)
    {
        $this->hasBlackHole = $hasBlackHole;
    }

    public function isOpened(): bool
    {
        return $this->opened;
    }

    public function open(): void
    {
        $this->opened = true;
    }

    public function getAdjacentBlackHolesCount(): int
    {
        return $this->adjacentBlackHolesCount;
    }

    public function setAdjacentBlackHolesCount(int $adjacentBlackHolesCount): void
    {
        $this->adjacentBlackHolesCount = $adjacentBlackHolesCount;
    }

    public function hasBlackHole(): bool
    {
        return $this->hasBlackHole;
    }
}