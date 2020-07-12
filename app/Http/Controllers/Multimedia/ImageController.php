<?php

namespace App\Http\Controllers\Multimedia;


use App\Http\Controllers\MyBaseController;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImageController extends MyBaseController
{

    public function show(Filesystem $filesystem, $path)
    {
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => $filesystem->getDriver(),
            'cache' => $filesystem->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url' => 'img',
        ]);
        return $server->getImageResponse($path, request()->all());
    }

    public function saveFileAwsS3($file, $directory)
    {
        try {
            $fileOriginalName = $file->getClientOriginalName();
            $extension = pathinfo($fileOriginalName, PATHINFO_EXTENSION);
            $fileName = "_" . uniqid() . uniqid() . '.' . $extension;
            Storage::disk('s3')->put("$directory/$fileName", file_get_contents($file), 'public');
            return $fileName;
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$file->getClientOriginalName(),]);
            throw $e;
        }
    }

}
