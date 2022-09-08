<?php

namespace App\Http\Services\File;

use Illuminate\Support\Str;

class FileToolsService
{


    protected $file;
    protected $disk;
    protected $exclusiveDirectory;
    protected $fileDirectory;
    protected $fileName;
    protected $fileSize;
    protected $fileFormat;
    protected $finalFileDirectory;
    protected $finalFileName;


    public function setFile($file)
    {
        $this->file = $file;
    }

    public function setDisk($disk)
    {
        $this->disk = $disk;
    }

    public function getDisk()
    {
        return $this->disk;
    }


    public function getExclusiveDirectory()
    {
        return $this->exclusiveDirectory;
    }


    public function setExclusiveDirectory($exclusiveDirectory)
    {
        $this->exclusiveDirectory = trim($exclusiveDirectory, '/\\');
    }



    public function getFileDirectory()
    {
        return $this->fileDirectory;
    }


    public function setFileDirectory($fileDirectory)
    {
        $this->fileDirectory = trim($fileDirectory, '/\\');
    }


    public function getFileName()
    {
        return $this->fileName;
    }


    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFileSize()
    {
        return $this->fileSize;
    }


    public function setFileSize($file)
    {
        $this->fileSize = $file->getSize();
    }

    public function setFileOriginalName()
    {
        return !empty($this->file) ? $this->setFileName(pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME)) : false;
    }



    public function getFileFormat()
    {
        return $this->fileFormat;
    }


    public function setFileFormat($file)
    {
        $this->fileFormat = $file->getClientOriginalExtension();
    }

    public function getFinalFileDirectory()
    {
        return $this->disk === 'public' ? public_path('storage' . DIRECTORY_SEPARATOR . $this->finalFileDirectory) : storage_path($this->finalFileDirectory);
    }


    public function setFinalFileDirectory($finalFileDirectory)
    {
        $this->finalFileDirectory = $finalFileDirectory;
    }

    public function getFinalFileName()
    {
        return $this->finalFileName;
    }


    public function setFinalFileName($finalFileName)
    {
        $this->finalFileName = $finalFileName;
    }

    protected function checkDirectory($fileDirectory)
    {

        if (!file_exists($fileDirectory)) {
            mkdir($fileDirectory, 0755, true);
        }
    }

    public function getFileAddress()
    {
        return $this->finalFileDirectory . DIRECTORY_SEPARATOR . $this->finalFileName;
    }



    protected function provider()
    {

        //set properties
        $this->getDisk() ?? $this->setDisk('public');
        $this->getFileDirectory() ?? $this->setFileDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d'));
        $this->getFileName() ?? $this->setFileOriginalName();
        $this->setFileFormat($this->file);
        $this->setFileSize($this->file);



        //set final file directory
        $finalFileDirectory = empty($this->getExclusiveDirectory()) ? $this->getFileDirectory() : $this->getExclusiveDirectory() . DIRECTORY_SEPARATOR . $this->getFileDirectory();
        $this->setFinalFileDirectory($finalFileDirectory);


        //set final file name

        $this->setFinalFileName($this->getFileName() . '.' . $this->getFileFormat());

        //check and create final file directory

        $this->checkDirectory($this->getFinalFileDirectory());
    }
}
