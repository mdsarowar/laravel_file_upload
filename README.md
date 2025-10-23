# LaravelFileUpload

LaravelFileUpload is a simple package for uploading and processing files `(images, PDFs, etc.)` in a Laravel
application. It supports image resizing using the `Intervention Image` library and allows you to handle file uploads to
both public and storage directories.

## Version

**Current Version:** 2.0.0

## Features

    - Upload files (images, PDFs, etc.)
    - Resize images (optional)
    - Save files to public or storage directories
    - Automatic directory creation if it doesn't exist
    - Handles deletion of existing files before uploading a new one

## Installation

You can install the package via Composer:

```php
composer require sarowar/laravel-dynamic-file-upload

```

## Publishing Configuration

To publish the configuration file, run the following command:

```php
php artisan vendor:publish --provider="Sarowar\LaravelFileUpload\FileUploadServiceProvider"

```

- This will create a configuration file named `sarowar-file-upload.php` in the config directory of your Laravel
  application. You can customize the settings in this file according to your requirements.

## Usage

Here’s a basic example of how to use the slug generator:

```php
use Sarowar\LaravelFileUpload\FileUpload;
```

```php
// Create an instance of the fileupload
$fileUpload = new FileUpload();
```

```php
// Generate a fileupload
 $fileUpload->fileUpload( $uploadedFile, // Image object
            'uploads/',    // Upload directory
            'static-pdf',// Image name prefix
            '300',//width in this image 
            '300',// Height in this image
            'webp'// extension in this image if you want to change 
        );
```

## Configuration

You can customize the slug generation by modifying the `config/sarowar-file-upload.php` file. Options include:

-`'file_path' => 'storage', `// Change to 'storage' if you prefer to use the storage folder

## Contributing

- Contributions are welcome! Please open an issue or submit a pull request.
