<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Output\OutputInterface;

class Printer
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function print(string $image, int $maxWidth, int $maxHeight): void
    {
        $reader = new Reader($image, $maxWidth, $maxHeight);

        [$width, $height] = $reader->getScaledDimensions($maxWidth, $maxHeight);

        for ($y = 0; $y < $height; $y += 2) {
            for ($x = 0; $x < $width; $x++) {
                $bgColor = $reader->getImagePixel($x, $y)->toHex();
                $fgColor = $reader->getImagePixel($x, $y + 1)->toHex();
                $this->output->write(sprintf('<fg=%s;bg=%s>▄</>', $fgColor, $bgColor));
            }

            $this->output->write(PHP_EOL);
        }
    }
}
