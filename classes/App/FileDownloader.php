<?php

namespace App;

use Common\StorageInterface,
    Common\Request,
    Common\Response;

/**
 * Class FileDownloader
 * Downloads a file from file's storage (StorageInterface implementation)
 * @package App
 */
class FileDownloader
{
    /**
     * Storage of files
     * @var StorageInterface
     */
    protected $fileStorage;

    /**
     * Name of the requested file
     * @var string
     */
    protected $inputFileName;

    /**
     * Name of the file to download from storage
     * @var string
     */
    protected $fileName;

    /**
     * Full path to a file to download
     * @var string
     */
    protected $filePath;

    /**
     * FileDownloader constructor.
     * @param StorageInterface $fileStorage
     * @param array $params
     * @throws \Exception
     */
    public function __construct(StorageInterface $fileStorage, $params = [])
    {
        $this->fileStorage = $fileStorage;
        $this->validateParams($params);
        $this->validateFileName($params['fileName']);
        $this->validateInputFileName($params['inputFileName']);
        $this->fileName = $params['fileName'];
        $this->inputFileName = $params['inputFileName'];
        $this->filePath = $this->fileStorage->getFilePath($this->fileName);
    }

    /**
     * Validates input params
     * @param array $params
     * @return bool
     * @throws \Exception
     */
    protected function validateParams($params = [])
    {
        if(!isset($params['fileName'])) {
            throw new \Exception("Filename parameter is required");
        }
        if(!isset($params['inputFileName'])) {
            throw new \Exception("InputFilename parameter is required");
        }
        return true;
    }

    /**
     * Validates filename
     * @param $fileName
     * @return bool
     * @throws \Exception
     */
    protected function validateFileName($fileName)
    {
        if(!preg_match('/^([-\.\w]+)$/', $fileName)) {
            throw new \Exception("Filename is not valid: {$fileName}");
        }
        return true;
    }

    protected function validateInputFileName($inputFileName)
    {
        if(!preg_match('/^([-\.\w]+)\.exe$/', $inputFileName)) {
            throw new \Exception("InputFilename is not valid: {$inputFileName}");
        }
        return true;
    }

    /**
     * Sets headers
     */
    protected function setHeaders()
    {
        Response::setHeaders([
            'Content-Description' => 'File Transfer',
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $this->inputFileName . '"',
            'Expires' => 0,
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public',
            'Content-Length: ' . filesize($this->filePath),
        ]);
    }

    /**
     * Downloads file from file's storage, reads file from storage to output
     */
    public function download()
    {
        try {
            // Sets HTTP headers
            $this->setHeaders();
            // Sets cookie
            Response::setCookie([
                'name' => 'referrer',
                'value' => Request::getReferer(),
                'expire' => 0
            ]);
            // Reads file from storage to output
            $this->fileStorage->get($this->fileName);
        } catch(\Exception $ex) {
            echo "Error: {$ex->getMessage()}";
        }
    }

}
