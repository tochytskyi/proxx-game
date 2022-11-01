<?php

declare(strict_types=1);

namespace Proxx\Part1;

use InvalidArgumentException;
use OutOfRangeException;

/**
 * Class that represents game's state:
 *
 * - board: 2-dimensional array where each value is instance if Cell class. @see Cell
 *   Cell class is convenient to represent each cell state and quickly get any item by O(1).
 *   Board is immutable.
 *
 * - width & height: represent size of the board
 *
 * - withBlackHolesCoordinates: auxiliary lightweight array where keys templated like "x:y"
 *   to quickly track all cells with black holes by O(1) if we know X and Y.
 *   Used to easily check if a cell has black hole and do not use extra Cell instances initializations.
 *   It also helps easily check if game is finished by comparing to openedCoordinates property
 *
 * - openedCoordinates: auxiliary lightweight array to quickly track all opened cells by O(1).
 *   Used to easily check if the game is finished by comparing to withBlackHolesCoordinates property
 */
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
    private array $openedCoordinates = [];

    public function __construct(int $width, int $height)
    {
        $this->checkWidth($width);
        $this->checkHeight($height);

        $this->width = $width;
        $this->height = $height;

        foreach (range(0, $width - 1) as $x) {
            foreach (range(0, $height - 1) as $y) {
                $this->board[$x][$y] = new Cell(false);
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
        } else {
            unset($this->withBlackHolesCoordinates["{$x}:{$y}"]);
        }

        if ($cell->isOpened()) {
            $this->openedCoordinates["{$x}:{$y}"] = [$x, $y];
        } else {
            unset($this->openedCoordinates["{$x}:{$y}"]);
        }
    }

    public function refresh(): void
    {
        $this->board = [];
        $this->withBlackHolesCoordinates = [];
        $this->openedCoordinates = [];

        foreach (range(0, $this->width - 1) as $x) {
            foreach (range(0, $this->height - 1) as $y) {
                $this->board[$x][$y] = new Cell(false);
            }
        }
    }

    public function getWithBlackHolesCoordinates(): array
    {
        return $this->withBlackHolesCoordinates;
    }

    public function isCellWithBlackHole(int $x, int $y): bool
    {
        $this->checkX($x);
        $this->checkY($y);

        return isset($this->withBlackHolesCoordinates["{$x}:{$y}"]);
    }

    public function isFinished(): bool
    {
        return count($this->openedCoordinates) === ($this->width * $this->height - count($this->withBlackHolesCoordinates));
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