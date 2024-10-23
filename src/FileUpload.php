<?php
namespace Sarowar\LaravelFileUpload;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileUpload
{
    public function fileUpload($file, $imageDirectory, $imageNameString = null, $width = null, $height = null, $newextension = null, $existlFileUrl = null)
    {
        // Check if file exists
        if ($file) {
            // Delete existing file if provided
            if (isset($existlFileUrl) && file_exists($existlFileUrl)) {
                unlink($existlFileUrl);
            }

            $filePath = config('sarowar-file-upload.file_path');

            // Create the directory if it doesn't exist
            if ($filePath == 'public') {
                $storagePath = public_path($imageDirectory);
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0777, true);
                }
            } else {
                $storagePath = storage_path( $imageDirectory);
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0777, true);
                }
            }
            // Determine the file name and extension
            $extension = $newextension ?: $file->getClientOriginalExtension();
            $imageName = (isset($imageNameString) ? $imageNameString : 'new') . '-' . time() . rand(10, 1000) . '.' . $extension;
            // Move the uploaded file to the specified directory
            $fileUrl = $imageDirectory . $imageName;



            // If the file is an image, process it
            if ($width && $height) {
                $file->move(public_path('sarowar/fileupload/'), $imageName); // Move to public path
                $manager = new ImageManager(new Driver());

                $file = $manager->read('sarowar/fileupload/'.$imageName);
                if ($width && $height) {
                    $file->resize($width, $height);
                }
                // Save the resized image to the correct path
                if ($filePath == 'public') {
                    $file->save(public_path($fileUrl));
                    if (file_exists('sarowar/fileupload/'.$imageName)) {
                        unlink('sarowar/fileupload/'.$imageName);
                    }
                }else{
                    $file->save(storage_path($fileUrl));
                    if (file_exists('sarowar/fileupload/'.$imageName)) {
                        unlink('sarowar/fileupload/'.$imageName);
                    }
                }
            }else{
                if ($filePath == 'public') {
                    $file->move(public_path($imageDirectory), $imageName); // Move to public path
                }else{
                    $file->move(storage_path($imageDirectory), $imageName); // Move to storage path
                }
            }
            return $fileUrl; // Return the file URL
        } else {
            return $existlFileUrl; // Return the existing file URL if no new file is uploaded
        }
    }
}
