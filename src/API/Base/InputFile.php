<?php

declare(strict_types = 1);

namespace Telegram\API\Base;

class InputFile {

    /**
     * Path to the file
     * @var null|string
     */
    private $_filePath = NULL;

    /**
     * InputFile constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath) {
        $this->_filePath = $filePath;
    }

    /**
     * Used to create the CURLFile from the provided filePath
     * @return \CURLFile
     */
    public function getCurlFile() : \CURLFile {
        return new \CURLFile($this->_filePath);
    }
}
