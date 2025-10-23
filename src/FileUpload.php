<?php
namespace Sarowar\LaravelFileUpload;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileUpload
{
    public static function fileUpload($file, $imageDirectory, $imageNameString = null, $width = null, $height = null, $newextension = null, $existlFileUrl = null)
    {
        // Get file path configuration (public or storage)
        $filePath = config('sarowar-file-upload.file_path', 'storage');

        // Check if file exists
        if ($file) {
            // Delete existing file if provided
            if (isset($existlFileUrl) && !empty($existlFileUrl)) {
                // Construct full path based on configuration
                if ($filePath == 'public') {
                    $fullExistingPath = public_path($existlFileUrl);
                } else {
                    $fullExistingPath = storage_path('app/public/' . $existlFileUrl);
                }

                // Check and delete if file exists
                if (file_exists($fullExistingPath)) {
                    unlink($fullExistingPath);
                }
            }

            // Determine storage path based on configuration
            if ($filePath == 'public') {
                $storagePath = public_path($imageDirectory);
            } else {
                $storagePath = storage_path('app/public/' . $imageDirectory);
            }

            // Create the directory if it doesn't exist
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0777, true);
            }

            // Determine the file name and extension
            $extension = $newextension ?: $file->getClientOriginalExtension();
            $imageName = (isset($imageNameString) ? $imageNameString : 'new') . '-' . time() . rand(10, 1000) . '.' . $extension;

            // Relative file URL for database storage
            $fileUrl = $imageDirectory . $imageName;

            // If the file is an image and needs resizing
            if ($width && $height) {
                // Create temporary directory for processing
                $tempDir = public_path('sarowar/fileupload/');
                if (!file_exists($tempDir)) {
                    mkdir($tempDir, 0777, true);
                }

                // Move to temporary location
                $file->move($tempDir, $imageName);

                // Process image with Intervention Image
                $manager = new ImageManager(new Driver());
                $image = $manager->read($tempDir . $imageName);
                $image->resize($width, $height);

                // Save to final destination based on configuration
                if ($filePath == 'public') {
                    $image->save(public_path($fileUrl));
                } else {
                    $image->save(storage_path('app/public/' . $fileUrl));
                }

                // Delete temporary file
                $tempFilePath = $tempDir . $imageName;
                if (file_exists($tempFilePath)) {
                    unlink($tempFilePath);
                }
            } else {
                // Move file directly without resizing
                if ($filePath == 'public') {
                    $file->move(public_path($imageDirectory), $imageName);
                } else {
                    $file->move(storage_path('app/public/' . $imageDirectory), $imageName);
                }
            }

            return $fileUrl; // Return relative path for database
        } else {
            return $existlFileUrl; // Return existing file URL if no new file
        }
    }
}
