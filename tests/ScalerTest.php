<?php

declare(strict_types=1);

namespace App\Tests;

use App\Scaler;
use PHPUnit\Framework\TestCase;

class ScalerTest extends TestCase
{
    private Scaler $scaler;

    protected function setUp(): void
    {
        $this->scaler = new Scaler();
    }

    public function testSmallerImage(): void
    {
        [$width, $height] = $this->scaler->calculate(400, 200, 500, 600);

        static::assertSame(400, $width);
        static::assertSame(200, $height);
    }

    public function testLargerXImage(): void
    {
        [$width, $height] = $this->scaler->calculate(400, 200, 200, 600);

        static::assertSame(200, $width);
        static::assertSame(100, $height);
    }

    public function testLargerYImage(): void
    {
        [$width, $height] = $this->scaler->calculate(400, 200, 400, 100);

        static::assertSame(200, $width);
        static::assertSame(100, $height);
    }

    public function testLargerImage(): void
    {
        [$width, $height] = $this->scaler->calculate(400, 200, 100, 100);

        static::assertSame(100, $width);
        static::assertSame(50, $height);
    }
}
