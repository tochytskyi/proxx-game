<?php

declare(strict_types=1);

namespace Proxx\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Proxx\Part1\State;
use Proxx\Part2\InitCellsWithBlackHoles;

class InitCellsWithBlackHolesTest extends TestCase
{
    public function testLessAmountOfCells(): void
    {
        $state = new State(6, 7);
        $this->expectException(InvalidArgumentException::class);
        (new InitCellsWithBlackHoles($state))->init(0);
    }

    public function testGreaterAmountOfCells(): void
    {
        $state = new State(6, 7);
        $this->expectException(InvalidArgumentException::class);
        (new InitCellsWithBlackHoles($state))->init(31);
    }

    public function testSuccessInitWithBlackHoles(): void
    {
        $state = new State(6, 7);

        (new InitCellsWithBlackHoles($state))->init(3);

        $cellsWithBlackHoleCount = 0;

        foreach (range(0, 5) as $x) {
            foreach (range(0, 6) as $y) {
                $cellsWithBlackHoleCount += $state->getCell($x, $y)->hasBlackHole() ? 1 : 0;
            }
        }

        $this->assertEquals(3, $cellsWithBlackHoleCount);
    }
}