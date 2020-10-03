<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Mime\MimeTypes;

class Reader
{
    private $image;
    private string $imagePath;

    public function __construct(string $imagePath, int $maxWidth, int $maxHeight)
    {
        if (!is_file($imagePath)) {
            throw new \InvalidArgumentException(sprintf('Image "%s" does not exist', $imagePath));
        }

        if (!is_readable($imagePath)) {
            throw new \InvalidArgumentException(sprintf('Image "%s" is not readable', $imagePath));
        }

        $this->imagePath = $imagePath;

        $mimeType = (new MimeTypes())->guessMimeType($imagePath);

        if (null === $mimeType) {
            throw new \InvalidArgumentException(sprintf('Cannot guess mime type of image "%s"', $imagePath));
        }

        switch ($mimeType) {
            case 'image/png':
                $image = imagecreatefrompng($imagePath);
                break;
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($imagePath);
                break;
            case 'image/vnd.wap.wbmp':
                $image = imagecreatefromwbmp($imagePath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($imagePath);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Mime type "%s" is not supported', $mimeType));
        }

        [$width, $height] = getimagesize($this->imagePath);
        [$newWidth, $newHeight] = $this->getScaledDimensions($maxWidth, $maxHeight);

        $this->image = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($this->image, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    }

    /**
     * @return array<int, int>
     */
    public function getScaledDimensions(int $maxWidth, int $maxHeight): array
    {
        [$width, $height] = getimagesize($this->imagePath);

        return (new Scaler())->calculate($width, $height, $maxWidth, $maxHeight);
    }

    public function getImagePixel(int $x, int $y): Rgb
    {
        $rgb = imagecolorat($this->image, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        return new Rgb($r, $g, $b);
    }
}
