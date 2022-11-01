<?php

declare(strict_types=1);

namespace Proxx\Tests;

use PHPUnit\Framework\TestCase;
use Proxx\Part1\Cell;
use Proxx\Part1\State;
use Proxx\Part3\InitEmptyCells;

class InitEmptyCellsTest extends TestCase
{
    public function testDefaultCellsState(): void
    {
        $state = new State(5, 5);

        (new InitEmptyCells($state))->init();

        foreach (range(0, 4) as $x) {
            foreach (range(0, 4) as $y) {
                $this->assertEquals(0, $state->getCell($x, $y)->getAdjacentBlackHolesCount());
            }
        }
    }

    public function testStateWithOneAdjacentBlackHole(): void
    {
        $state = new State(5, 5);

        $state->setCell(0, 0, new Cell(true));

        (new InitEmptyCells($state))->init();

        $this->assertCount(1, $state->getWithBlackHolesCoordinates());

        $this->assertEquals(1, $state->getCell(0, 1)->getAdjacentBlackHolesCount());
        $this->assertEquals(1, $state->getCell(1, 0)->getAdjacentBlackHolesCount());
        $this->assertEquals(1, $state->getCell(1, 1)->getAdjacentBlackHolesCount());

        foreach (range(2, 4) as $x) {
            foreach (range(2, 4) as $y) {
                $this->assertEquals(0, $state->getCell($x, $y)->getAdjacentBlackHolesCount());
            }
        }
    }

    public function testStateWithTwoAdjacentBlackHoles(): void
    {
        $state = new State(5, 5);

        $state->setCell(0, 0, new Cell(true));
        $state->setCell(1, 0, new Cell(true));

        (new InitEmptyCells($state))->init();

        $this->assertCount(2, $state->getWithBlackHolesCoordinates());

        $this->assertEquals(2, $state->getCell(0, 1)->getAdjacentBlackHolesCount());
        $this->assertEquals(2, $state->getCell(1, 1)->getAdjacentBlackHolesCount());
        $this->assertEquals(1, $state->getCell(2, 0)->getAdjacentBlackHolesCount());
        $this->assertEquals(1, $state->getCell(2, 1)->getAdjacentBlackHolesCount());
    }

    public function testStateWithThreeAdjacentBlackHoles(): void
    {
        $state = new State(5, 5);

        $state->setCell(0, 0, new Cell(true));
        $state->setCell(1, 0, new Cell(true));
        $state->setCell(0, 1, new Cell(true));

        (new InitEmptyCells($state))->init();

        $this->assertCount(3, $state->getWithBlackHolesCoordinates());

        $this->assertEquals(3, $state->getCell(1, 1)->getAdjacentBlackHolesCount());
    }
}