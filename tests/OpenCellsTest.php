<?php

declare(strict_types=1);

namespace Proxx\Tests;

use PHPUnit\Framework\TestCase;
use Proxx\Part1\Cell;
use Proxx\Part1\State;
use Proxx\Part3\InitEmptyCells;
use Proxx\Part4\CellWithBlackHoleOpenedException;
use Proxx\Part4\OpenCell;
use Proxx\Utils\StatePrinter;

class OpenCellsTest extends TestCase
{
    public function testOpenWithBlackHole(): void
    {
        $state = new State(6, 7);
        $state->setCell(1, 1, new Cell(true));
        (new InitEmptyCells($state))->init();

        $this->expectException(CellWithBlackHoleOpenedException::class);

        (new OpenCell($state))->open(1, 1);
    }

    public function testOpenWithoutBlackHole(): void
    {
        $state = new State(6, 7);
        $state->setCell(1, 1, new Cell(true));
        (new InitEmptyCells($state))->init();

        (new OpenCell($state))->open(0, 0);

        $this->assertTrue($state->getCell(0, 0)->isOpened());
    }

    public function testOpenPropagation(): void
    {
        $state = new State(5, 5);
        $state->setCell(0, 0, new Cell(true));
        (new InitEmptyCells($state))->init();

        (new OpenCell($state))->open(4, 4);

        $this->assertTrue($state->getCell(4, 4)->isOpened());
        $this->assertTrue($state->getCell(4, 3)->isOpened());
        $this->assertTrue($state->getCell(4, 2)->isOpened());
        $this->assertTrue($state->getCell(4, 1)->isOpened());
        $this->assertTrue($state->getCell(4, 0)->isOpened());

        $this->assertTrue($state->getCell(3, 4)->isOpened());
        $this->assertTrue($state->getCell(3, 3)->isOpened());
        $this->assertTrue($state->getCell(3, 2)->isOpened());
        $this->assertTrue($state->getCell(3, 1)->isOpened());
        $this->assertTrue($state->getCell(3, 0)->isOpened());

        $this->assertTrue($state->getCell(2, 4)->isOpened());
        $this->assertTrue($state->getCell(2, 3)->isOpened());
        $this->assertTrue($state->getCell(2, 2)->isOpened());
        $this->assertTrue($state->getCell(2, 1)->isOpened());
        $this->assertTrue($state->getCell(2, 0)->isOpened());

        $this->assertTrue($state->getCell(1, 4)->isOpened());
        $this->assertTrue($state->getCell(1, 3)->isOpened());
        $this->assertTrue($state->getCell(1, 2)->isOpened());
        $this->assertTrue($state->getCell(1, 1)->isOpened());
        $this->assertTrue($state->getCell(1, 0)->isOpened());

        $this->assertTrue($state->getCell(0, 4)->isOpened());
        $this->assertTrue($state->getCell(0, 3)->isOpened());
        $this->assertTrue($state->getCell(0, 2)->isOpened());
        $this->assertTrue($state->getCell(0, 1)->isOpened());

        $this->assertFalse($state->getCell(0, 0)->isOpened());
    }

    public function testFromStartToTheWin(): void
    {
        $state = new State(5, 5);
        $state->setCell(1, 1, new Cell(true));
        $state->setCell(3, 3, new Cell(true));
        (new InitEmptyCells($state))->init();

        $this->assertFalse($state->isFinished());
        (new OpenCell($state))->open(2, 2);

        $this->assertTrue($state->getCell(4, 0)->isOpened());
        $this->assertTrue($state->getCell(3, 0)->isOpened());
        $this->assertTrue($state->getCell(2, 0)->isOpened());

        $this->assertTrue($state->getCell(4, 1)->isOpened());
        $this->assertTrue($state->getCell(3, 1)->isOpened());
        $this->assertTrue($state->getCell(2, 1)->isOpened());

        $this->assertTrue($state->getCell(0, 2)->isOpened());
        $this->assertTrue($state->getCell(1, 2)->isOpened());
        $this->assertTrue($state->getCell(2, 2)->isOpened());
        $this->assertTrue($state->getCell(3, 2)->isOpened());
        $this->assertTrue($state->getCell(4, 2)->isOpened());

        $this->assertTrue($state->getCell(0, 3)->isOpened());
        $this->assertTrue($state->getCell(1, 3)->isOpened());
        $this->assertTrue($state->getCell(2, 3)->isOpened());

        $this->assertTrue($state->getCell(0, 4)->isOpened());
        $this->assertTrue($state->getCell(1, 4)->isOpened());
        $this->assertTrue($state->getCell(2, 4)->isOpened());

        $this->assertFalse($state->isFinished());
        (new OpenCell($state))->open(0, 0);

        $this->assertTrue($state->getCell(0, 0)->isOpened());
        $this->assertTrue($state->getCell(1, 0)->isOpened());
        $this->assertTrue($state->getCell(0, 1)->isOpened());

        $this->assertFalse($state->isFinished());
        (new OpenCell($state))->open(4, 4);

        $this->assertTrue($state->getCell(4, 4)->isOpened());
        $this->assertTrue($state->getCell(4, 3)->isOpened());
        $this->assertTrue($state->getCell(4, 4)->isOpened());

        $this->assertTrue($state->isFinished());
    }
}