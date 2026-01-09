<?php

namespace App\Service;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Ou Imagick selon ton serveur
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\String\Slugger\SluggerInterface;

class AvatarUploader
{
    private ImageManager $imageManager;

    public function __construct(
        private string $avatarDirectory,
        private Filesystem $filesystem
    ) {
        $this->imageManager = new ImageManager(new Driver());
    }

    public function uploadAvatar(UploadedFile $file, int $userId, ?string $oldAvatar = null): string
    {
        $fileName = sprintf('user-%d-%s.webp', $userId, uniqid());
        $image = $this->imageManager->read($file->getPathname());
        $image->cover(400, 400); 

        $image->toWebp(80)->save($this->avatarDirectory . '/' . $fileName);

        if ($oldAvatar) {
            $this->removeOldAvatar($oldAvatar);
        }

        return $fileName;
    }

    public function removeOldAvatar(string $fileName): void
    {
        $filePath = $this->avatarDirectory . '/' . $fileName;
        if ($this->filesystem->exists($filePath)) {
            $this->filesystem->remove($filePath);
        }
    }

    public function getAvatarDirectory(): string
    {
        return $this->avatarDirectory;
    }
}