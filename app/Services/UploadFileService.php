<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use League\Flysystem\FilesystemException;
use App\Exceptions\Services\UploadFileException;
use Illuminate\Support\Facades\Crypt;

class UploadFileService
{
    public function store(
        \Illuminate\Http\UploadedFile $file,
        ?string $path = '',
        ?string $disk = 's3',
        ?bool $expectMetadata = true
    ): string | array | false {
        try {
            $id = uniqid();
            $filename = $this->generateFileName($id, $file);

            $result = $file->storeAs($path, $filename, $disk);
            if ($result === false) {
                throw new UploadFileException("Got false as a result when uploading");
            }

            return $expectMetadata ? $this->metadata($id, $file, $result) : $result;
        } catch (FilesystemException $e) {
            throw new UploadFileException("Failed to upload file: {$e->getMessage()}", 0, $e);
        } catch (\Exception $e) {
            throw new UploadFileException("Unexpected error during file upload: {$e->getMessage()}", 0, $e);
        }
    }

    public function metadata(string $id, UploadedFile $file, string $path): array
    {
        return [
            'id' => $id,
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'type' => $file->getClientOriginalExtension(),
            'url' => Crypt::encryptString(
                json_encode([
                    'path' => $path,
                    'filename' => $file->getClientOriginalName()
                ])
            )
        ];
    }

    private function generateFileName(string $id, UploadedFile $file)
    {
        return $id . '_' . time() . '.' . $file->getClientOriginalExtension();
    }
}
