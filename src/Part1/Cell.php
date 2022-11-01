<?php

declare(strict_types=1);

namespace Proxx\Part1;

class Cell {

    private bool $opened = false;

    private int $adjacentBlackHolesCount = 0;

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