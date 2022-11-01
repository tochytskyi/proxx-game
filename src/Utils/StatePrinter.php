<?php

namespace Proxx\Utils;

use Proxx\Part1\State;

class StatePrinter {

    private State $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function printOpened(): void
    {
        echo PHP_EOL;

        foreach (range(0, $this->state->getWidth() - 1) as $x) {
            echo ' | ';

            foreach (range(0, $this->state->getHeight() - 1) as $y) {
                $cell = $this->state->getCell($x, $y);
                echo $this->state->getCell($x, $y)->hasBlackHole() ? '.' : $cell->getAdjacentBlackHolesCount();
                echo ' | ';
            }

            echo PHP_EOL;
        }
    }

    public function print(): void
    {
        echo PHP_EOL;

        foreach (range(0, $this->state->getWidth() - 1) as $x) {
            echo ' | ';

            foreach (range(0, $this->state->getHeight() - 1) as $y) {
                $cell = $this->state->getCell($x, $y);

                if ($cell->isOpened()) {
                    echo $this->state->getCell($x, $y)->hasBlackHole() ? '.' : $cell->getAdjacentBlackHolesCount();
                } else {
                    echo 'X';
                }

                echo ' | ';
            }

            echo PHP_EOL;
        }
    }
}