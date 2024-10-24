<?php

namespace Sarowar\LaravelFileUpload;

use Illuminate\Support\ServiceProvider;

class FileUploadServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('laravel-file_upload',function ($app){
            return new \Sarowar\LaravelFileUpload\FileUpload();
        });
    }

    public function boot()
    {
        // Publish the configuration file
        $this->publishes([
            __DIR__.'/config/sarowar-file-upload.php' => config_path('sarowar-file-upload.php'),
        ]);

        // Load the configuration file
        $this->mergeConfigFrom(
            __DIR__.'/config/sarowar-file-upload.php', 'sarowar-file-upload'
        );
    }

}
