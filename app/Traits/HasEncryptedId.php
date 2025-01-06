<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use InvalidArgumentException;

trait HasEncryptedId
{
    /**
     * Get the encrypted version of the model's ID
     */
    public function getEncryptedId(): string
    {
        return Crypt::encryptString((string) $this->id);
    }

    /**
     * Find a model by its encrypted ID
     *
     * @param string $encryptedId
     * @return static|null
     */
    public static function findByEncryptedId(string $encryptedId): ?static
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            return static::find($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Find a model by its encrypted ID or throw an exception
     *
     * @param string $encryptedId
     * @return static
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function findByEncryptedIdOrFail(string $encryptedId): static
    {
        $model = static::findByEncryptedId($encryptedId);

        if (!$model) {
            throw (new \Illuminate\Database\Eloquent\ModelNotFoundException)->setModel(static::class);
        }

        return $model;
    }

    /**
     * Decrypt an encrypted ID
     *
     * @param string $encryptedId
     * @return int|null
     */
    public static function decryptId(string $encryptedId): ?int
    {
        try {
            return (int) Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            return null;
        }
    }
}
