<?php

declare(strict_types = 1);

namespace Telegram\Storage\Migrations;

use Telegram\API\Base\Abstracts\ABaseObject;

class TelegramAdapter {

    private $_datamodel = NULL;
    private $_telegramClass = NULL;

    /**
     * TelegramAdapter constructor.
     * @param \Telegram\API\Base\Abstracts\ABaseObject $telegramClass
     */
    public function __construct(ABaseObject $telegramClass) {
        $this->_datamodel = $telegramClass::GetDatamodel();
        $this->_telegramClass = $telegramClass;
    }

    /**
     * Get the properties from the baseObject
     * @param bool $getOptional
     * @return \Generator
     */
    public function getProperties(bool $getOptional = TRUE) : \Generator {
        foreach ($this->_datamodel as $property => $settings) {
            if (!$getOptional && $settings['optional']) {
                continue;
            }
            yield $property;
        }
    }

    /**
     * Get the base className from the provided ABaseObject
     * @return string
     */
    public function getClassBaseName() : string {
        return static::GetBaseObjectClassBaseName($this->_telegramClass);
    }

    /**
     * @param \Telegram\API\Base\Abstracts\ABaseObject $object
     * @return string
     */
    public static function GetBaseObjectClassBaseName(ABaseObject $object) : string {
        return (new \ReflectionClass($object))->getShortName();
    }

    /**
     * Get the type for a certain property
     * @param string $property
     * @return mixed
     * @throws \Exception
     */
    public function getTypeForProperty(string $property) {
        if (!isset($this->_datamodel[$property])) {
            throw new \Exception(get_class($this->_telegramClass) . " doesn't have a property called $property!");
        }
        return $this->_datamodel[$property]['type'];
    }

    /**
     * Get a custom field from the datamodel
     * @param string $property
     * @param string $field
     * @return mixed
     * @throws \Exception
     */
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
