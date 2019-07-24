<?php

declare(strict_types = 1);

namespace Telegram\API\Base\Abstracts;

use Telegram\API\Base\InputFile;
use Telegram\Storage\Interfaces\{IStorageHandlerAware, ITelegramStorageHandler};

abstract class ABaseObject implements IStorageHandlerAware {

    const T_STRING = 'string';
    const T_INT = 'integer';
    const T_FLOAT = 'float';
    const T_BOOL = 'boolean';
    const T_ARRAY = 'array';
    const T_OBJECT = 'object';

    const PROP_TYPE = 'type';
    const PROP_OPTIONAL = 'optional';
    const PROP_EXTERNAL = 'external';
    const PROP_CLASS = 'class';
    const PROP_CONTENT = 'content';


    /**
     * @var null|\Telegram\Storage\Interfaces\ITelegramStorageHandler
     */
    private $_storageHandler = NULL;

    /**
     * Id field property used for StorageHandlers
     * @var string
     */
    protected static $_IdProp = '';

    /**
     * Used to store values according to the provided datamodel
     * @var array
     */
    private $_values = [];

    /**
     * the loaded datamodel
     * @var array|null
     */
    protected $_datamodel = NULL;

    /**
     * Used to check whether the object has a storage handler
     * @return bool
     */
    public function hasStorageHandler() : bool {
        return $this->_storageHandler instanceof ITelegramStorageHandler;
    }

    /**
     * Used to return the storageHandler
     */
    public function getStorageHandler() : ITelegramStorageHandler {
        return $this->_storageHandler;
    }

    /**
     * Set the storageHandler
     */
    public function setStorageHandler(ITelegramStorageHandler $storageHandler) {
        $this->_storageHandler = $storageHandler;
    }

    /**
     * Used to store the object if there is a StorageHandler
     * @return bool
     */
    public function store() : bool {
        if ($this->hasStorageHandler()) {
            return $this->_storageHandler->store(static::class, $this);
        }
        return FALSE;
    }

    /**
     * Used to delete this object from storage
     * @return bool
     */
    public function delete() : bool {
        if ($this->hasStorageHandler()) {
            return $this->_storageHandler->delete($this);
        }
        return FALSE;
    }

    /**
     * ABaseObject constructor.
     * @param \stdClass|NULL $payload
     */
    public function __construct(\stdClass $payload = NULL) {
        $this->_datamodel = static::GetDatamodel();
        if ($payload) {
            $internalFields = array_keys($this->_datamodel);
            foreach ($payload as $field => $value) {
                if (!in_array($field, $internalFields)) {
                    $field = $this->getInternalField($field);
                }
                if ($field === 'unknown') {
                    continue;
                }
                if (is_object($value)) {
                    $class = $this->_getFieldProperty($field, self::PROP_CLASS);
                    if (is_array($class)) {
                        throw new \LogicException('This field can be a few different classes! Please implement a custom constructor!');
                    }
                    $value = new $class($value);
                }
                $this->{$field} = $value;
            }
        }
    }

    /**
     * Magic getter used to retrieve the values of the properties defined in the datamodel
     * @param string $name
     * @return mixed
     */
    public function __get(string $name) {
        $sName = lcfirst($name);
        if (isset($this->_values[$sName])) {
            return $this->_values[$sName];
        }
        throw new \LogicException('Unknown field \'' . $name . '\' for object: ' . get_class($this) . '!');
    }

    /**
     * Magic setter used to set the values of the properties defined in the datamodel
     * @param string $name
     * @param $value
     * @throws \Exception
     */
    public function __set(string $name, $value) {
        $sName = lcfirst($name);
        if ($this->hasField($name)) {
            $fieldType = $this->getFieldType($sName);
            $providedType = self::GetTypeForVar($value);
            $type = self::GetTypeForVar($value);
            $isOfCorrectType = FALSE;
            if (is_array($fieldType) && in_array($type, $fieldType) || $type === $fieldType) {
                $isOfCorrectType = TRUE;
            }
            if (!$isOfCorrectType && is_scalar($value)) {
                if (is_array($fieldType)) {
                    $temp = $fieldType;
                    $usingType = array_shift($temp);
                } else {
                    $usingType = $fieldType;
                }
                if (in_array($usingType, [self::T_STRING, self::T_INT, self::T_FLOAT, self::T_BOOL])) {
                    switch ($usingType) {
                        case self::T_STRING:
                            $value = (string) $value;
                            break;
                        case self::T_INT:
                            $value = (int) $value;
                            break;
                        case self::T_FLOAT:
                            $value = (float) $value;
                            break;
                        case self::T_BOOL:
                            $value = (bool) $value;
                            break;
                    }
                    $isOfCorrectType = TRUE;
                }
            }
            if ($isOfCorrectType) {
                if ($fieldType === self::T_OBJECT) {
                    $classes = $this->_getFieldProperty($sName, self::PROP_CLASS);
                    if (!is_array($classes)) {
                        $classes = [$classes];
                    }
                    $isPropperClass = FALSE;
                    foreach ($classes as $class) {
                        if ($value instanceof $class) {
                            $isPropperClass = TRUE;
                            break;
                        }
                    }
                    if (!$isPropperClass) {
                        throw new \Exception('Object of type \'' . get_class($value) . '\' is not an instance of ' . implode(', ', $classes) . '!');
                    }
                }
                $this->_values[$sName] = $value;
            } else {
                if (is_array($fieldType)) {
                    $errorType = implode(',', $fieldType);
                } else {
                    $errorType = $fieldType;
                }
                if ($providedType === NULL) {
                    $providedType = 'NULL';
                }
                throw new \LogicException("Unexpected type provided for $name. Expected $errorType but got $providedType!");
            }
        } else {
            throw new \LogicException('Unknown field \'' . $name . '\'!');
        }
    }

    /**
     * Used to check if a value of the datamodel is set
     * @param string $name
     * @return bool
     */
    public function __isset(string $name) : bool {
        return isset($this->_values[$name]);
    }

    /**
     * Used to define set and get methods for the properties defined in the datamodel
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call(string $name, array $arguments) {
        $type = substr($name, 0, 3);
        if ($type === 'set' || $type === 'get') {

            $sName = substr($name, 3);
            if ($this->hasProperty($sName)) {

                if ($type === 'set') {
                    $this->__set($sName, reset($arguments));
                } elseif ($type === 'get') {
                    return $this->__get($sName);
                }

            }

        }

        throw new \Exception('Unknown method ' . $name);
    }

    /**
     * Used to only show the values when using var_dump to explore the object
     * @return array
     */
    public function __debugInfo() : array {
        return [
            'values' => $this->_values
        ];
    }

    /**
     * Used to check if a field has been defined by the datamodel
     * @param string $name
     * @return bool
     */
    public function hasField(string $name) : bool {
        return isset($this->_datamodel[$name]);
    }

    /**
     * Used to get the Fully Qualified Class Name of the loaded object
     * @return string
     */
    public function getFQCN() : string {
        return static::class;
    }

    /**
     * Used to get a field property from the datamodel
     * @param string $field
     * @param string $property
     * @return mixed
     */
    private function _getFieldProperty(string $field, string $property) {
        if ($this->hasField($field)) {
            if (isset($this->_datamodel[$field][$property])) {
                return $this->_datamodel[$field][$property];
            }
        }
        return NULL;
    }

    /**
     * Used to get the property type of a field
     * @param string $name
     * @return mixed
     */
    public function getFieldType(string $name) {
        return $this->_getFieldProperty($name, self::PROP_TYPE);
    }

    /**
     * Used to check if a field actually has a value
     * @param string $name
     * @return bool
     */
    public function hasFieldValue(string $name) : bool {
        return isset($this->{$name});
    }

    /**
     * Used to check if a property is optional
     * @param string $name
     * @return bool
     */
    public function isOptional(string $name) : bool {
        return $this->_getFieldProperty($name, self::PROP_OPTIONAL);
    }

    /**
     * Used to get the externally used name
     * @param string $name
     * @return string
     */
    public function getExternalField(string $name) : string {
        return $this->_getFieldProperty($name, self::PROP_EXTERNAL);
    }

    /**
     * Used to get the internal (php) field name. Returns unknown when the field has not been found
     * @param string $name
     * @return string
     */
    public function getInternalField(string $name) : string {
        foreach ($this->_datamodel as $field => $settings) {
            if ($settings[self::PROP_EXTERNAL] === $name) {
                return $field;
            }
        }
        return 'unknown';
    }

    /**
     * Check whether the class has an Id field
     * @return bool
     */
    public static function HasIdProperty() : bool {
        return !empty(static::$_IdProp);
    }

    /**
     * Used to get the Id property name
     * @return string
     */
    public static function GetIdProperty() {
        return static::$_IdProp;
    }

    /**
     * Used to set the Id property name
     * @param string $propName
     */
    public static function SetIDProperty(string $propName) {
        $datamodel = static::GetDatamodel();
        if (!isset($datamodel[$propName])) {
            throw new \LogicException('Unknown property ' . $propName . '!');
        }
        static::$_IdProp = $propName;
    }

    /**
     * Used to get the type for a variable
     * @param $var
     * @return string|NULL
     */
    public static function GetTypeForVar($var) {
        $type = gettype($var);
        switch ($type) {
            case 'boolean':
                return self::T_BOOL;
            case 'integer':
                return self::T_INT;
            case 'double':
                return self::T_FLOAT;
            case 'string':
                return self::T_STRING;
            case 'array':
                return self::T_ARRAY;
            case 'object':
                if ($var instanceof ABaseObject || $var instanceof InputFile) {
                    return self::T_OBJECT;
                }
                break;
        }
        return NULL;
    }

    /**
     * Encode this object to a json string
     * @return string
     */
    public function getJSON() : string {
        return self::EncodeJSON($this->jsonify());
    }

    /**
     * returns the object as MultipartFormData
     * @return array
     * @throws \Exception
     */
    public function getMultipartFormData() : array {
        $payload = [];
        $attachments = [];

        $convertValue = function($item) use (&$attachments) {
            if ($item instanceof AInputMedia) {
                if ($item->hasAttachment()) {
                    $attachName = 'attachment' . count($attachments);
                    $attachments[$attachName] = $item->getAttachment()->getCurlFile();
                    $item->media = 'attach://' . $attachName;
                }
                if ($item->hasThumbAttachment()) {
                    $attachName = 'attachment' . count($attachments);
                    $attachments[$attachName] = $item->getThumbAttachment()->getCurlFile();
                    $item->thumb = 'attach://' . $attachName;
                }
            }
            if ($item instanceof InputFile) {
                $item = $item->getCurlFile();
            } elseif ($item instanceof ABaseObject) {
                $item = $item->jsonify();
            }
            return $item;
        };

        foreach (array_keys($this->_datamodel) as $field) {
            $external = $this->getExternalField($field);
            if ($this->hasFieldValue($field)) {
                $value = $this->{$field};
                if (is_array($value)) {
                    array_walk_recursive($value, function(&$item) use ($convertValue) {
                        $item = $convertValue($item);
                    });
                } else {
                    $value = $convertValue($value);
                }

                $payload[$external] = $value;
            } elseif (!$this->isOptional($field)) {
                throw new \Exception('Required field \'' . $field . '\' has not been set!');
            }
        }
        return array_merge($payload, $attachments);
    }

    /**
     * Used to get the payload of the class
     * @return array|string
     */
    public function getPayload() {
        if ($this->hasInputFile()) {
            return $this->getMultipartFormData();
        } else {
            return $this->getJSON();
        }
    }

    /**
     * Used to get the payload type
     * @return string
     */
    public function getPayloadType() : string {
        if ($this->hasInputFile()) {
            return 'MultiPartFormData';
        } else {
            return 'JSON';
        }
    }

    /**
     * Used to check whether one of the fields set is an InputFile
     * @return bool
     */
    public function hasInputFile() {
        $hasInputFile = FALSE;
        array_walk_recursive($this->_values, function($item) use (&$hasInputFile) {
            if ($item instanceof AInputMedia) {
                if ($item->hasAttachment()) {
                    $hasInputFile = TRUE;
                }
                if ($item->hasThumbAttachment()) {
                    $hasInputFile = TRUE;
                }
            }
            if ($item instanceof InputFile) {
                $hasInputFile = TRUE;
            }
        });
        return $hasInputFile;
    }

    /**
     * Get a jsonified representation of the object
     * @return mixed
     * @throws \Exception
     */
    public function jsonify() {
        $payload = new \stdClass;

        foreach (array_keys($this->_datamodel) as $field) {
            $external = $this->getExternalField($field);
            if ($this->hasFieldValue($field)) {
                $value = $this->{$field};
                $fieldType = $this->getFieldType($field);
                switch ($fieldType) {
                    case self::T_OBJECT:
                        $value = $value->jsonify();
                        break;
                    case self::T_ARRAY:
                        array_walk_recursive($value, function(&$item) {
                            if ($item instanceof ABaseObject) {
                                $item = $item->jsonify();
                            }
                        });
                        break;
                }
                $payload->{$external} = $value;
            } elseif (!$this->isOptional($field)) {
                throw new \Exception('Required field \'' . $field . '\' has not been set!');
            }
        }

        return $payload;
    }

    public function validateProperties() : bool {
        foreach (array_keys($this->_datamodel) as $field) {
            if ($this->hasFieldValue($field)) {
                $fieldType = $this->getFieldType($field);
                switch ($fieldType) {
                    case self::T_OBJECT:
                        $res = $value->validateProperties();
                        if (!$res) {
                            return FALSE;
                        }
                        break;
                    case self::T_ARRAY:
                        $res = TRUE;
                        array_walk_recursive($value, function($item) use (&$res) {
                            if ($item instanceof ABaseObject) {
                                $valid = $item->validateProperties();
                                if (!$valid) {
                                    $res = FALSE;
                                }
                            }
                        });
                        if (!$res) {
                            return FALSE;
                        }
                        break;
                }
            } elseif (!$this->isOptional($field)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Used to get the datamodel definition of the class
     * @return array
     */
    public static function GetDatamodel() : array {
        return [];
    }

    /**
     * Encode a stdClass to json
     * @param \stdClass $structure
     * @return string
     */
    public static function EncodeJSON(\stdClass $structure) : string {
        $str = json_encode($structure);
        if ($str === FALSE) {
            $err = json_last_error();
            switch ($err) {
                case JSON_ERROR_DEPTH:
                    throw new \LogicException('JSON encode error: Maximum stack depth exceeded');
                case JSON_ERROR_UTF8:
                    throw new \LogicException('JSON encode error: Malformed UTF-8 characters');
                default:
                    throw new \LogicException('JSON encode error: Unknown error (' . $err . ')');
            }
        }
        return $str;
    }

    /**
     * Decode a json string to a stdClass
     * @param string $jsonString
     * @param bool $throw
     * @return \stdClass|null
     */
    public static function DecodeJSON(string $jsonString, bool $throw = TRUE) {
        $obj = json_decode($jsonString, FALSE);
        if ($obj === NULL && $throw) {
            $err = json_last_error();
            switch ($err) {
                case JSON_ERROR_NONE:
                    break;
                case JSON_ERROR_DEPTH:
                    throw new \LogicException('JSON decode error: Maximum stack depth exceeded');
                case JSON_ERROR_STATE_MISMATCH:
                    throw new \LogicException('JSON decode error: Underflow or the modes mismatch');
                case JSON_ERROR_CTRL_CHAR:
                    throw new \LogicException('JSON decode error: Unexpected control character found');
                case JSON_ERROR_SYNTAX:
                    throw new \LogicException('JSON decode error: Syntax error, malformed JSON');
                case JSON_ERROR_UTF8:
                    throw new \LogicException('JSON decode error: Malformed UTF-8 characters, possibly incorrectly encoded');
                default:
                    throw new \LogicException('JSON decode error: Unknown error (' . $err . ')');
            }
        }
        return $obj;
    }

    /**
     * Used to compare two ABaseObject objects to see if they are equal
     * @param \Telegram\API\Base\Abstracts\ABaseObject $object
     * @return bool
     */
    public function isEqual(ABaseObject $object) : bool {
        if ($this === $object) {
            return TRUE;
        }
        if (get_class($this) !== get_class($object)) {
            return FALSE;
        }
        foreach ($this->_values as $key => $value) {
            if (!isset($object->{$key})) {
                return FALSE;
            }
            if ($value !== $object->{$key}) {
                return FALSE;
            }
        }
        return TRUE;
    }
}
