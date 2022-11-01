<?php

declare(strict_types=1);

namespace Proxx\Part1;

use InvalidArgumentException;
use OutOfRangeException;

class State {

    public const MIN_X = 5;
    public const MIN_Y = 5;
    public const MAX_X = 100;
    public const MAX_Y = 100;

    /**
     * @var array<int,array<int,Cell>>
     */
    private array $board = [];

    private int $width;

    private int $height;

    /**
     * @var array<string,int[]>
     */
    private array $withBlackHolesCoordinates = [];

    /**
     * @var array<string,int[]>
     */
    private array $withoutBlackHolesCoordinates = [];

    public function __construct(int $width, int $height)
    {
        $this->checkWidth($width);
        $this->checkHeight($height);

        $this->width = $width;
        $this->height = $height;

        foreach (range(0, $width - 1) as $x) {
            foreach (range(0, $height - 1) as $y) {
                $this->board[$x][$y] = new Cell(false);
                $this->withoutBlackHolesCoordinates["{$x}:{$y}"] = [$x, $y];
            }
        }
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getCell(int $x, int $y): Cell
    {
        $this->checkX($x);
        $this->checkY($y);

        return clone $this->board[$x][$y];
    }

    public function setCell(int $x, int $y, Cell $cell): void
    {
        $this->checkX($x);
        $this->checkY($y);

        $this->board[$x][$y] = clone $cell;

        if ($cell->hasBlackHole()) {
            $this->withBlackHolesCoordinates["{$x}:{$y}"] = [$x, $y];
            unset($this->withoutBlackHolesCoordinates["{$x}:{$y}"]);
        } else {
            $this->withoutBlackHolesCoordinates["{$x}:{$y}"] = [$x, $y];
            unset($this->withBlackHolesCoordinates["{$x}:{$y}"]);
        }
    }

    public function getWithBlackHolesCoordinates(): array
    {
        return $this->withBlackHolesCoordinates;
    }

    public function getWithoutBlackHolesCoordinates(): array
    {
        return $this->withoutBlackHolesCoordinates;
    }

    public function isCellWithBlackHole(int $x, int $y): bool
    {
        $this->checkX($x);
        $this->checkY($y);

        return isset($this->withBlackHolesCoordinates["{$x}:{$y}"]);
    }

    private function checkWidth(int $value): void
    {
        if ($value < self::MIN_X || $value > self::MAX_X) {
            throw new InvalidArgumentException('Invalid width. Should be in a range ' . self::MIN_X . ':' . self::MAX_X);
        }
    }

    private function checkHeight(int $value): void
    {
        if ($value < self::MIN_Y || $value > self::MAX_Y) {
            throw new InvalidArgumentException('Invalid height. Should be in a range ' . self::MIN_X . ':' . self::MAX_X);
        }
    }

    private function checkX(int $value): void
    {
        if ($value < 0 || $value > ($this->width - 1)) {
            throw new OutOfRangeException('Invalid X. Should be in a range 0:' . ($this->width - 1));
        }
    }

    private function checkY(int $value): void
    {
        if ($value < 0 || $value > ($this->height - 1)) {
            throw new OutOfRangeException('Invalid Y. Should be in a range 0:' . ($this->height - 1));
        }
    }
}