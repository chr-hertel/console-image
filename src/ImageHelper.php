<?php

declare(strict_types=1);

namespace Stoffel\Console\Image;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Terminal;

class ImageHelper
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function print(string $imagePath, int $maxWidth = null, int $maxHeight = null): void
    {
        $terminal = new Terminal();
        $maxWidth = $maxWidth ?? $terminal->getWidth();
        $maxHeight = $maxHeight ?? $terminal->getHeight() * 2 - 4;

        $reader = new Reader($imagePath, $maxWidth, $maxHeight);

        [$width, $height] = $reader->getScaledDimensions($maxWidth, $maxHeight);

        $output = '';
        for ($y = 0; $y < $height; $y += 2) {
            for ($x = 0; $x < $width; $x++) {
                $bgColor = $reader->getImagePixel($x, $y)->toHex();
                $fgColor = $y + 1 >= $height ? 'black' : $reader->getImagePixel($x, $y + 1)->toHex();
                $output .= sprintf('<fg=%s;bg=%s>▄</>', $fgColor, $bgColor);
            }

            $output .= PHP_EOL;
        }

        $this->output->write($output);
    }
}
