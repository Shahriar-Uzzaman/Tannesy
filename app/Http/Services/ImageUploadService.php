<?php

namespace App\Http\Services;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    protected string $disk;

    public function __construct()
    {
        $this->disk = config('filesystem.default', 'public');
    }

    public function normalizeName(string $directory): string
    {
        return trim($directory, '/');
    }

    public function storeFile(UploadedFile $image, string $directory): string|false
    {
        $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();

        return $image->storeAs(
            $this->normalizeName($directory),
            $imageName,
            $this->disk
        );
    }

    public function fileExists(string $path): bool
    {
        return Storage::disk($this->disk)->exists($path);
    }

    public function deleteFile(string $path): bool
    {
        return Storage::disk($this->disk)->delete($path);
    }

    public function delete(Image $image): ?bool
    {
        $this->deleteFile($image->path);

        return $image->delete();
    }

    public function upload(UploadedFile $image, string $directory, Model $imageable): Image
    {
        $path = $this->storeFile($image, $directory);

        if ($path === false) {
            throw new \RuntimeException('Failed to store file.');
        }

        return Image::create([
            'path' => $path,
            'imageable_id' => $imageable->getKey(),
            'imageable_type' => $imageable->getMorphClass(),
        ]);
    }
}
