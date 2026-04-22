<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;


class ImageUploadService
{

    const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB
    const MAX_IMAGES_PER_PROPERTY = 6;
    const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png'];
    const WEBP_QUALITY = 70;

    public function validateImage(UploadedFile $file): array
    {

    }

    public function uploadImages(array $images, string $referenceNumber): array
    {

    }


    private function convertToWebP(UploadedFile $image, string $propertyPath, int $imageNumber): array
    {

    }


    public function deleteImage(string $imagePath): bool
    {

    }


    public function deletePropertyImages(string $referenceNumber): bool
    {

    }


    public function getPropertyImagesCount(string $referenceNumber): int
    {

    }

    public function getPropertyImages(string $referenceNumber): array
    {

    }


    public function canUploadMoreImages(string $referenceNumber, int $newImagesCount): array
    {

    }

    public function getImageUrl(string $imagePath): string
    {

    }
}
