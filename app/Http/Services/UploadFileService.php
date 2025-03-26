<?php
/**
 * Service for uploading file
 *
 * PHP version 8.1
 *
 * @category UploadFileService
 * @package  App\Http\Services
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Services;

use Carbon\Carbon;
use Exception;
use Storage;
use File;

/**
 * Service for uploading files
 *
 * PHP version 8.1
 *
 * @category UploadFileService
 * @package  App\Http\Services
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
class UploadFileService
{
    /**
     * Store file
     *
     * @param String|Object $file file data
     * @param string        $type file type
     * @param int           $dir  dir name
     *
     * @author meet.panchal
     *
     * @return mixed
     */
    public function upload(object $file, string $type, int $dir): mixed
    {
        try {
            $ext      = $file->getClientOriginalExtension();
            $file     = file_get_contents($file);
            $fileName = $type . '_' . time() . '.' . $ext;
            $path     = $this->getFileUploadPath($type, $dir);

            $response = Storage::put($path . $fileName, $file);
            if ($response) {
                return $fileName;
            }
            return false;
        } catch (Exception $e) {
            return ['error' => 'FILE_UPLOAD_FAILED', 'data' => $e->getMessage()];
        }
    }

    /**
     * Get file upload path
     *
     * @param string $type image type
     * @param int    $dir  dir name
     *
     * @author meet.panchal
     *
     * @return string
     */
    public function getFileUploadPath(string $type, int $dir): string
    {
        $path = 'uploads/';
        if ($type == 'category'
        ) {
            $path .= 'category/' . $dir . '/';
        }
        if ($type == 'main_img'
        ) {
            $path .= 'product/main_img/' . $dir . '/';
        }
        if ($type == 'sec_img'
        ) {
            $path .= 'product/sec_img/' . $dir . '/';
        }
        if ($type == 'thrd_img'
        ) {
            $path .= 'product/thrd_img/' . $dir . '/';
        }

        return $path;
    }

    /**
     * Get file upload path
     *
     * @param string $fileName filename
     * @param string $type     file folder name
     * @param int    $dir      dir name
     *
     * @author meet.panchal
     *
     * @return string
     */
    public function getUploadedFileUrl(string $fileName, string $type, int $dir): string
    {
        $getpath = $this->getFileUploadPath($type, $dir);
        $getpath .= $fileName;
        return Storage::disk('local')->url($getpath);
        // return Storage::url($getpath);
    }

    /**
     * Delete File - Common Bucket
     *
     * @param string $fileName filename
     * @param string $type     file folder name
     * @param int    $dir      dir name
     *
     * @author meet panchal
     *
     * @return true|false
     */
    public function deleteFile(string $fileName, string $type, int $dir): bool
    {
        $getpath  = $this->getFileUploadPath($type, $dir);
        $getpath .= $fileName;

        if (Storage::exists($getpath)) {
            Storage::delete($getpath);
            return true;
        }
        return false;
    }
}
