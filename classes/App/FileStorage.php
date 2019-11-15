<?php

namespace App;

use Common\StorageInterface;

/**
 * Class FileStorage
 * Storage of files, StorageInterface implementation
 * @package App
 */
class FileStorage implements StorageInterface
{
    /**
     * Storage files directory
     * @var string
     */
    public $fileStorageDir;

    /**
     * FileStorage constructor.
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->fileStorageDir = isset($params['fileStorageDir']) ? $params['fileStorageDir'] : PROJECTROOT;
    }

    /**
     * Reads a file from storage to output, if file exists
     * @param $fileName
     * @throws \Exception
     */
    public function get($fileName)
    {
        $filePath = $this->getFilePath($fileName);
        if(!file_exists($filePath)) {
            throw new \Exception("File not found in storage - {$filePath}");
        }
        flush(); // Flush system output buffer
        readfile($filePath);
        exit;
    }

    /**
     * Returns path to file in storage
     * @param $fileName
     * @return string
     */
    public function getFilePath($fileName)
    {
        return $this->fileStorageDir . '/' . $fileName;
    }

}