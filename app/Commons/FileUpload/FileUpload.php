<?php


namespace App\Commons\FileUpload;


use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\Uuid;

class FileUpload
{
    /** @var $file UploadedFile */
    private $file;

    /** @var $targetPath string */
    private $targetPath;

    /**
     * FileUpload constructor.
     * @param UploadedFile $file
     * @param string $targetPath
     */
    public function __construct($file, $targetPath)
    {
        $this->file = $file;
        $this->targetPath = $targetPath;
    }

    public function upload(): FileUploadResponse
    {
        $response = new FileUploadResponse();
        try {
            $file = $this->getFile();
            $extension = $file->getClientOriginalExtension();
            $fileName = Uuid::uuid4()->toString() . '.' . $extension;
            $path = $this->file->storeAs($this->targetPath, $fileName, 'public');
            $urlFileName = '/storage/' . $path;
            $response->setSuccess(true)
                ->setMessage('success')
                ->setData($urlFileName);
        } catch (\Exception $e) {
            $response->setSuccess(false)
                ->setMessage($e->getMessage())
                ->setData(null);
        }
        return $response;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     * @return FileUpload
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string
     */
    public function getTargetPath()
    {
        return $this->targetPath;
    }

    /**
     * @param string $targetPath
     * @return FileUpload
     */
    public function setTargetPath($targetPath)
    {
        $this->targetPath = $targetPath;
        return $this;
    }
}
