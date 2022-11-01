<?php

declare(strict_types=1);

namespace Proxx\Part4;

use DomainException;
use Throwable;

class CellWithBlackHoleOpenedException extends DomainException {

    private int $x;
    private int $y;

    public function __construct(int $x, int $y, ?Throwable $previous = null)
    {
        parent::__construct("Cell with a black hole opened. Game over!", 0, $previous);

        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }
}