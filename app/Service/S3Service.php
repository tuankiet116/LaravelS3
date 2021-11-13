<?php
namespace App\Service;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class S3Service{
    /**
   * Upload file role private.
   *
   * @param object $file
   * @param string $path
   * @param boolean $isRename
   *
   * @return boolean|string
   */
    public function uploadFile(object $file, string $customName = null, string $path = null, bool $isRename = true)
    {
        try {
            $fileName = $customName ?? $this->getFileName($file, $isRename);
            $key = $this->getUploadKey($fileName);
            Storage::disk('s3')->put($key, file_get_contents($file));

            return $fileName;
        } catch (Exception $e) {
            Log::error('[ERROR_S3_UPLOAD_IMAGE] =>' . $e->getMessage());

            return false;
        }
    }

    /**
     * Get file name.
     *
     * @param object $file
     * @param boolean $isRename
     *
     * @return string
     */
    public function getFileName(object $file, bool $isRename): string
    {
        $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = $isRename ? $this->getFileNameRandom($fileName, $extension) : $fileName;

        return $fileName;
    }

    /**
     * Get file name random.
     *
     * @param string $fileName
     * @param string $extension
     *
     * @return string
     */
    public function getFileNameRandom(string $fileName, string $extension): string
    {
        $fileName = str_replace('.' . $extension, '', $fileName);
        $fileName = $fileName . '_' . time() . '.' . $extension;

        return $fileName;
    }

    /**
     * Gennerate presigned url has expried time.
     *
     * @param string $name
     * @param string $path
     *
     * @return null|string
     */
    public function getUrl(string $name, string $path = null)
    {
        $expiryTime = Carbon::now()->addMinutes(config('filesystems.disks.s3.default_expried_time'));
        try {
            return Storage::disk('s3')->temporaryUrl(
                $name,
                $expiryTime
            );
        } catch (Exception $e) {
            Log::error('ERROR_S3_GET_URL:' . $e->getMessage());

            return null;
        }
    }

    /**
     * Delete file.
     *
     * @param string $name
     * @param string $path
     *
     * @return boolean
     */
    public function deleteFile(string $name, string $path = null): bool
    {
        try {
            $key = $this->getUploadKey($name);

            return Storage::disk('s3')->delete($key);
        } catch (Exception $e) {
            Log::error('[ERROR_S3_DELETE_IMAGE] =>' . $e->getMessage());

            return false;
        }
    }

    /**
     * Get upload key to s3.
     *
     * @param string $name name.
     * @param string $path path.
     *
     * @return string
     */
    protected function getUploadKey(string $name): string
    {
        return sprintf('%s', $name);
    }

    //If you need to add a path default so you should fix this code
    //author: tuankiet
}
