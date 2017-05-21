#!/usr/bin/env php
<?php

class ConfigGenerator {

    public function __construct() {
        $this->{'UseCaCertFile'} = TRUE;
        $this->{'CA-certfile'} = 'cacert.pem';
    }

    protected function _createConfig() {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

    public function create() {
        @file_put_contents('./TelegramConfig.json', $this->_createConfig());
    }

}

$generator = new ConfigGenerator;
$generator->create();
