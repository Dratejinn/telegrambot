<?php

declare(strict_types = 1);

namespace Telegram\API\Base;

class InputFile {
    private $_filePath = NULL;

    public function __construct(string $filePath) {
        $this->_filePath = $filePath;
    }

    public function getCurlFile() : \CURLFile {
        return new \CURLFile($this->_filePath);
    }
}
