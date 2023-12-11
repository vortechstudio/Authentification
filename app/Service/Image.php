<?php

namespace App\Service;

use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\File;
class Image
{
    public function __construct(
        private string $file,
    )
    {
    }

    public function resize(array $sizes): void
    {
        $file = new File($this->file);
        $manager = new ImageManager(['driver' => "gd"]);
        $directory = dirname($file->getRealPath());
        // Base File
        $manager
            ->make($file->getRealPath())
            ->save("{$directory}/{$file->getBasename()}.webp");
        foreach ($sizes as $size) {
            $manager
                ->make($file->getRealPath())
                ->crop(100,100)
                ->fit($size, $size)
                ->save("{$directory}/{$file->getBasename()}_{$size}x{$size}.webp");
        }
    }

    public function deleteInitialFile(): void
    {
        $file = new File($this->file);
        $directory = dirname($file->getRealPath());

        unlink("{$directory}/{$file->getBasename()}.".$file->getExtension());
    }
}
