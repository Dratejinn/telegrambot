<?php

declare(strict_types = 1);

namespace Telegram\Storage\Migrations;

use Telegram\API\Base\Abstracts\ABaseObject;

class TelegramAdapter {

    private $_datamodel = NULL;
    private $_telegramClass = NULL;

    public function __construct(ABaseObject $telegramClass) {
        $this->_datamodel = $telegramClass::GetDatamodel();
        $this->_telegramClass = $telegramClass;
    }

    public function getProperties(bool $getOptional = TRUE) : \Generator {
        foreach ($this->_datamodel as $property => $settings) {
            if (!$getOptional && $settings['optional']) {
                continue;
            }
            yield $property;
        }
    }

    public function getClassBaseName() : string {
        return (new \ReflectionClass($this->_telegramClass))->getShortName();
    }

    public function getTypeForProperty(string $property) {
        if (!isset($this->_datamodel[$property])) {
            throw new \Exception(get_class($this->_telegramClass) . " doesn't have a property called $property!");
        }
        return $this->_datamodel[$property]['type'];
    }

    public function getCustomFieldForProperty(string $property, string $field) {
        if (!isset($this->_datamodel[$property])) {
            throw new \Exception(get_class($this->_telegramClass) . " doesn't have a property called $property!");
        }
        if (!isset($this->_datamodel[$property][$field])) {
            throw new \Exception(get_class($this->_telegramClass) . " doesn't have a custom field named $field for property '$property'!");
        }
        return $this->_datamodel[$property][$field];
    }

}
