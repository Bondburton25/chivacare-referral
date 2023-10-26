<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function show($filename)
    {
        return redirect(Storage::disk('s3')->getTemporaryUrl('upload'/$filename, ['ResponseContentDisposition' => 'attachment']));
    }
}
