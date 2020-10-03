<?php

declare(strict_types=1);

namespace App;

class Scaler
{
    /**
     * @return array<int, int>
     */
    public function calculate(int $width, int $height, int $maxWidth, int $maxHeight): array
    {
        $ratio = $height / $width;

        $newWidth = $width <= $maxWidth ? $width : $maxWidth;
        $newHeight = $newWidth * $ratio;

        if ($newHeight > $maxHeight) {
            $newWidth = $maxHeight / $ratio;
            $newHeight = $maxHeight;
        }

        return [
            (int)round($newWidth),
            (int)round($newHeight),
        ];
    }
}
