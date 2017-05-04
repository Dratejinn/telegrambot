<?php

declare(strict_types = 1);

namespace Telegram\API\Base\Abstracts;

use Telegram\API\Base\InputFile;

abstract class ABaseObject {

    const T_STRING = 'string';
    const T_INT = 'integer';
    const T_FLOAT = 'float';
    const T_BOOL = 'bool';
    const T_ARRAY = 'array';
    const T_OBJECT = 'object';

    const PROP_TYPE = 'type';
    const PROP_OPTIONAL = 'optional';
    const PROP_EXTERNAL = 'external';
    const PROP_CLASS = 'class';
    const PROP_CONTENT = 'content';

    private $_values = [];

    protected $_datamodel = NULL;

    public function __construct(\stdClass $payload = NULL) {
        $this->_datamodel = static::GetDatamodel();
        if ($payload) {
            foreach ($payload as $externalField => $value) {
                $field = $this->getInternalField($externalField);
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

    public function __get(string $name) {
        $sName = lcfirst($name);
        if (isset($this->_values[$sName])) {
            return $this->_values[$sName];
        }
        throw new \LogicException('Unknown field \'' . $name . '\'!');
    }

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
                        throw new \Exception('Object of type \'' . get_class($value) . '\' is not an instance of ' . $class . '!');
                    }
                }
                $this->_values[$sName] = $value;
            } else {
                if (is_array($fieldType)) {
                    $errorType = implode(',', $fieldType);
                } else {
                    $errorType = $fieldType;
                }
                throw new \LogicException("Unexpected type provided for $name. Expected $errorType but got $providedType!");
            }
        } else {
            throw new \LogicException('Unknown field \'' . $name . '\'!');
        }
    }

    public function __isset(string $name) : bool {
        return isset($this->_values[$name]);
    }

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

    public function __debugInfo() : array {
        return [
            'values' => $this->_values
        ];
    }

    public function hasField(string $name) : bool {
        return isset($this->_datamodel[$name]);
    }

    private function _getFieldProperty(string $field, string $property) {
        if ($this->hasField($field)) {
            if (isset($this->_datamodel[$field][$property])) {
                return $this->_datamodel[$field][$property];
            }
        }
    }

    public function getFieldType(string $name) {
        return $this->_getFieldProperty($name, self::PROP_TYPE);
    }

    public function hasFieldValue(string $name) : bool {
        return isset($this->{$name});
    }

    public function isOptional(string $name) : bool {
        return $this->_getFieldProperty($name, self::PROP_OPTIONAL);
    }

    public function getExternalField(string $name) : string {
        return $this->_getFieldProperty($name, self::PROP_EXTERNAL);
    }

    public function getInternalField(string $name) : string {
        foreach ($this->_datamodel as $field => $settings) {
            if ($settings[self::PROP_EXTERNAL] === $name) {
                return $field;
            }
        }
        // echo 'Got a field that is not yet added with name: ' . $name . PHP_EOL;
        return 'unknown';
    }

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
    }

    public function getJSON() : string {
        return self::EncodeJSON($this->jsonify());
    }

    public function getMultipartFormData() : array {
        $payload = [];

        $convertValue = function($item) {
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
        return $payload;
    }

    public function getPayload() {
        if ($this->hasInputFile()) {
            return $this->getMultipartFormData();
        } else {
            return $this->getJSON();
        }
    }

    public function getPayloadType() : string {
        if ($this->hasInputFile()) {
            return 'MultiPartFormData';
        } else {
            return 'JSON';
        }
    }

    public function hasInputFile() {
        $hasInputFile = FALSE;
        array_walk_recursive($this->_values, function($item) use (&$hasInputFile) {
            if ($item instanceof InputFile) {
                $hasInputFile = TRUE;
            }
        });
        return $hasInputFile;
    }

    public function jsonify() : \stdClass {
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

    public static function GetDatamodel() : array {
        return [];
    }

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
                    throw new \LogicException('JSON encode error: Unknown error ('.$err.')');
            }
        }
        return $str;
    }

    public static function DecodeJSON(string $jsonString) : \stdClass {
        $obj = json_decode($jsonString, FALSE);
        if ($obj === NULL) {
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
                    throw new \LogicException('JSON decode error: Unknown error ('.$err.')');
            }
        }
        return $obj;
    }
}
