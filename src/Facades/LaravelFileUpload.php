<?php
namespace Sarowar\LaravelFileUpload\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @see \Sarowar\LaravelFileUpload\FileUpload;
 */
class LaravelFileUpload extends Facade
{

    protected static function getFacadeAccessor()
    {
      return 'laravel-file_upload';
    }
}
