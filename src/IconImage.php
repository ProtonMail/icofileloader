<?php

namespace Elphin\IcoFileLoader;

/**
 * Holds data on an image within an Icon
 */
class IconImage
{
    /**
     * @var integer Width, in pixels, of the image
     */
    public $width;
    /**
     * @var integer Height, in pixels, of the image
     */
    public $height;
    /**
     * @var integer Number of colors in image
     */
    public $colorCount;
    /**
     * @var integer Reserved ( must be 0)
     */
    public $reserved;
    /**
     * @var integer Color Planes
     */
    public $planes;
    /**
     * @var integer bits per pixel
     */
    public $bitCount;
    /**
     * @var integer How many bytes in this resource?
     */
    public $sizeInBytes;
    /**
     * @var integer Where in the file is this image?
     */
    public $fileOffset;

    /**
     * @var integer size of BITMAPINFOHEADER structure
     */
    public $bmpHeaderSize;

    /**
     * @var integer image width from BITMAPINFOHEADER
     */
    public $bmpHeaderWidth;

    /**
     * @var integer image height from BITMAPINFOHEADER
     */
    public $bmpHeaderHeight;

    /**
     * @var ?string PNG file for icon images which use PNG
     */
    public ?string $pngData = null;

    /**
     * @var ?string BMP bitmap data for images which use BMP
     */
    public ?string $bmpData = null;

    public array $palette = [];

    /**
     * @param array $data array of data extracted from a ICONDIRENTRY binary structure
     */
    public function __construct(array $data)
    {
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }
    }

    public function getDescription(): string
    {
        return sprintf(
            '%dx%d pixel %s @ %d bits/pixel',
            $this->width,
            $this->height,
            $this->isPng() ? 'PNG' : 'BMP',
            $this->bitCount
        );
    }

    /**
     * Stores binary PNG file for the icon
     */
    public function setPngFile(string $pngData): void
    {
        $this->pngData = $pngData;
    }

    public function isPng(): bool
    {
        return !empty($this->pngData);
    }

    public function isBmp(): bool
    {
        return empty($this->pngData);
    }

    public function setBitmapInfoHeader($bmpInfo)
    {
        //bit depth can be zero in the ICONDIRENTRY, we trust the bitmap header more...
        $this->bitCount = $bmpInfo['BitCount'];

        //we need this to calculate offsets when rendering
        $this->bmpHeaderWidth = $bmpInfo['Width'];
        $this->bmpHeaderHeight = $bmpInfo['Height'];
        $this->bmpHeaderSize = $bmpInfo['Size'];
    }

    public function setBitmapData(string $bmpData): void
    {
        $this->bmpData = $bmpData;
    }

    public function addToBmpPalette(int $r, int $g, int $b, int $reserved): void
    {
        $this->palette[] = ['red' => $r, 'green' => $g, 'blue' => $b, 'reserved' => $reserved];
    }
}
