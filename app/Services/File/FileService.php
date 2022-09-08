<?php

namespace App\Http\Services\File;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileService extends FileToolsService
{

    public function saveInPublic($file)
    {
        //set file
        $this->setFile($file);

        //set disk
        $this->setDisk('public');
        
        //execute provider
        $this->provider();

        //save file
        $result = $file->move($this->getFinalFileDirectory(), $this->getFinalFileName());
        return $result ? $this->getFileAddress() : false;
    }

    public function saveInStorage($file)
    {
        //set file
        $this->setFile($file);
        
        //set disk
        $this->setDisk('private');

        //execute provider
        $this->provider();

        //save file
        $result = $file->move($this->getFinalFileDirectory(), $this->getFinalFileName());
        return $result ? $this->getFileAddress() : false;
    }

    public function moveFile($filePath, $from, $to)
    {

        if ($from === 'private' && $to === 'public') {
            $realPath = storage_path($filePath);
            if (file_exists($realPath)) {
                $result = Storage::disk('public')->put($filePath, Storage::disk('private')->get($filePath));
                Storage::disk('private')->delete($filePath);

                return $result;
            }
            return false;
        } else {
            $realPath = storage_path('app\public\\' . $filePath);
            if (file_exists($realPath)) {

                $result = Storage::disk('private')->put($filePath, Storage::disk('public')->get($filePath));
                Storage::disk('public')->delete($filePath);

                return $result;
            }
            
            return false;
        }
    }


    public function deleteFile($filePath, $disk)
    {
        $realPath = $disk == 1 ? storage_path($filePath) : storage_path('app\public\\' . $filePath);
        if (file_exists($realPath)) {
            $result = $disk == 1 ? Storage::disk('private')->delete($filePath) : Storage::disk('public')->delete($filePath);
            return $result;
        }

        return redirect()->back()->with('alertify-error', 'فایل پیدا نشد');
    }


    public function renameFile($filePath, $oldName, $newName, $disk)
    {
        if ($disk == 1) {
            $realPath = storage_path($filePath);
            if (file_exists($realPath)) {
                $name = explode(DIRECTORY_SEPARATOR, $filePath);
                $name = $name[count($name) - 1];
                $fileFormat = explode('.', $name);
                if (count($fileFormat) >= 0) {
                    $fileFormat = $fileFormat[count($fileFormat) - 1];
                } else {
                    $fileFormat = $fileFormat[0];
                }
                $path = substr($filePath, 0, -strlen($name));

                $newPath = $path . $newName . '.' . $fileFormat;

                $tmp_path = $path . Str::random(16) . '.' . $fileFormat;
                Storage::disk('private')->rename($filePath, $tmp_path);
                $result = Storage::disk('private')->rename($tmp_path, $newPath);
                
                return $result ? $newPath : false;
            }
            return false;
        } else {
            $realPath = storage_path('app\public\\' . $filePath);
            if (file_exists($realPath)) {
                $name = explode(DIRECTORY_SEPARATOR, $filePath);
                $name = $name[count($name) - 1];
                $fileFormat = explode('.', $name);
                if (count($fileFormat) >= 0) {
                    $fileFormat = $fileFormat[count($fileFormat) - 1];
                } else {
                    $fileFormat = $fileFormat[0];
                }
                $path = substr($filePath, 0, -strlen($name));

                $newPath = $path . $newName . '.' . $fileFormat;

                $tmp_path = $path . Str::random(16) . '.' . $fileFormat;
                Storage::disk('public')->rename($filePath, $tmp_path);
                $result = Storage::disk('public')->rename($tmp_path, $newPath);

                return $result ? $newPath : false;
            }
            return false;
        }
    }
}
