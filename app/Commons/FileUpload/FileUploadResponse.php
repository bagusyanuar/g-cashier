<?php


namespace App\Commons\FileUpload;


class FileUploadResponse
{
    /** @var $success boolean */
    private $success;

    /** @var $message string */
    private $message;

    /** @var $data */
    private $data;

    /**
     * MultipleFileUploadResponse constructor.
     * @param bool $success
     * @param string $message
     * @param $data
     */
    public function __construct($success = false, $message = '', $data = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param bool $success
     * @return FileUploadResponse
     */
    public function setSuccess($success)
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return FileUploadResponse
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return FileUploadResponse
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
