<?php

declare(strict_types=1);

namespace Proxx\Tests;

use InvalidArgumentException;
use OutOfRangeException;
use PHPUnit\Framework\TestCase;
use Proxx\Part1\Cell;
use Proxx\Part1\State;

class StateTest extends TestCase
{
    public function testWrongWidth(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new State(1, 6);
    }

    public function testWrongHeight(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new State(6, 1);
    }

    public function testSuccessInitSize(): void
    {
        $state = new State(10, 11);

        $this->assertEquals(10, $state->getWidth());
        $this->assertEquals(11, $state->getHeight());
    }

    public function testDefaultCellsState(): void
    {
        $state = new State(5, 5);

        foreach (range(0, 4) as $x) {
            foreach (range(0, 4) as $y) {
                $this->assertInstanceOf(Cell::class, $state->getCell($x, $y));
                $this->assertFalse($state->getCell($x, $y)->hasBlackHole());
                $this->assertFalse($state->getCell($x, $y)->isOpened());
                $this->assertEquals(0, $state->getCell($x, $y)->getAdjacentBlackHolesCount());
            }
        }
    }

    public function testGetCellWithIncorrectX(): void
    {
        $state = new State(7, 7);
        $this->expectException(OutOfRangeException::class);
        $state->getCell(10, 6);
    }

    public function testGetCellWithIncorrectY(): void
    {
        $state = new State(7, 7);
        $this->expectException(OutOfRangeException::class);
        $state->getCell(6, 10);
    }

    public function testSetCellWithIncorrectX(): void
    {
        $state = new State(7, 7);
        $this->expectException(OutOfRangeException::class);
        $state->setCell(7, 6, new Cell());
    }

    public function testSetCellWithIncorrectY(): void
    {
        $state = new State(7, 7);
        $this->expectException(OutOfRangeException::class);
        $state->setCell(6, 7, new Cell());
    }

    public function testSuccessInitWithoutBlackHoles(): void
    {
        $state = new State(6, 7);

        $cellsWithBlackHoleCount = 0;

        foreach (range(0, 5) as $x) {
            foreach (range(0, 6) as $y) {
                $cellsWithBlackHoleCount += $state->getCell($x, $y)->hasBlackHole() ? 1 : 0;
            }
        }

        $this->assertEquals(0, $cellsWithBlackHoleCount);
    }
}