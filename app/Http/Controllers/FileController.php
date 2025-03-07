<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function serve($key)
    {
        $disk = Storage::disk('s3');
        $decryptKey = Crypt::decryptString($key);

        $data = json_decode($decryptKey, true);

        if ($data === null) {
            $path = $disk->path($data);
            $filename = '';
        } else {
            $path = $data['path'];
            $filename = $data['filename'];
        }

        if ($disk->exists($path)) {
            $filename = $filename ?: basename($disk->path($path));
            return $disk->response(
                $path,
                $filename,
                [
                    'Content-Disposition' => 'inline; filename="' . $filename . '"'
                ]
            );
        }

        abort(404, 'File tidak ditemukan');
    }
}
