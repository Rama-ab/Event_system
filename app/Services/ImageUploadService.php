<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;

class ImageUploadService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function upload(Model $model, UploadedFile $file): string
    {
        $path = $file->store('uploads/images', 'public');

        $model->images()->create([
            'path' => $path,
        ]);

        return $path;
    }
}
