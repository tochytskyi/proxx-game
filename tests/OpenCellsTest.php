<?php

declare(strict_types=1);

namespace Proxx\Tests;

use PHPUnit\Framework\TestCase;
use Proxx\Part1\State;
use Proxx\Part2\InitCellsWithBlackHoles;
use Proxx\Part3\InitEmptyCells;
use Proxx\Part4\CellWithBlackHoleOpenedException;
use Proxx\Part4\OpenCell;

class OpenCellsTest extends TestCase
{
    public function testOpenWithBlackHole(): void
    {
        $state = new State(6, 7);

        (new InitCellsWithBlackHoles($state))->init(5);
        (new InitEmptyCells($state))->init();

        $cellsWithBlackHoles = $state->getWithBlackHolesCoordinates();
        $cellWithBlackHole = array_pop($cellsWithBlackHoles);

        $this->expectException(CellWithBlackHoleOpenedException::class);

        (new OpenCell($state))->open($cellWithBlackHole[0], $cellWithBlackHole[1]);
    }

    public function testOpenWithoutBlackHole(): void
    {
        $state = new State(6, 7);

        (new InitCellsWithBlackHoles($state))->init(5);
        (new InitEmptyCells($state))->init();

        $cellsWithoutBlackHoles = $state->getWithoutBlackHolesCoordinates();
        $cellWithoutBlackHoles = array_pop($cellsWithoutBlackHoles);

        try {
            (new OpenCell($state))->open($cellWithoutBlackHoles[0], $cellWithoutBlackHoles[1]);
        } catch (CellWithBlackHoleOpenedException $exception) {
            var_dump($exception->getX(), $exception->getY());
            var_dump($state->getWithBlackHolesCoordinates());
            throw $exception;
        }

        $this->assertTrue($state->getCell($cellWithoutBlackHoles[0], $cellWithoutBlackHoles[1])->isOpened());
    }
}