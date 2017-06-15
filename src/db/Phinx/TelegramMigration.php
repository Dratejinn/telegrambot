<?php

declare(strict_types = 1);

namespace Telegram\db\Phinx;

use Phinx\Migration\AbstractMigration;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\Storage\Migrations\TelegramAdapter;

class TelegramMigration extends AbstractMigration {
    protected function _migrateTelegramClass(ABaseObject $telegramClass, string $tableName = NULL, bool $createOptionalColumns = TRUE, array $options = []) {
        $adapter = new TelegramAdapter($telegramClass);

        if ($tableName === NULL) {
            $tableName = $adapter->getClassBaseName();
        }

        $table = $this->table($tableName);
        foreach ($adapter->getProperties($createOptionalColumns) as $property) {
            $propType = $this->_getMySqlTypeForProperty($adapter, $property);
            $options = [];
            if (isset($options[$propType])) {
                if (isset($options[$propType][$propType])) {
                    $options = $options[$property][$propType];
                }
            }
            if ($property === 'id') {
                if ($propType == 'integer') {
                    continue;
                } else {
                    $property = 'telegram_id';
                }
            }
            $table->addColumn($property, $propType, $options);
        }
        $table->create();
    }

    protected function _getMySqlTypeForProperty(TelegramAdapter $adapter, string &$property) {
        $telegramType = $adapter->getTypeForProperty($property);

        //multiple types possible so get the best possible type
        if (is_array($telegramType) && count($telegramType) == 1) {
            $telegramType = $telegramType[0];
        }
        if (is_array($telegramType)) {
            if (in_array(ABaseObject::T_ARRAY || ABaseObject::T_OBJECT)) {
                return 'string';
            } elseif (in_array(ABaseObject::T_BOOL) && in_array(ABaseObject::T_INT) && count($telegramType) == 2) {
                return ABaseObject::T_INT;
            } else {
                //safe fallback
                return 'string';
            }
        }

        switch ($telegramType) {
            case ABaseObject::T_ARRAY:
                return 'string';
            case ABaseObject::T_OBJECT:
                $class = $adapter->getCustomFieldForProperty($property, 'class');
                if (is_a($class, ABaseObject::class, TRUE)) {
                    if ($class::HasIdProperty()) {
                        $idProperty = $class::GetIdProperty();
                        $classObj = new $class;
                        $adapter = new TelegramAdapter($classObj);
                        $properyType = $this->_getMySqlTypeForProperty($adapter, $idProperty);
                        $property = $property . '_' . $idProperty;
                        return $properyType;
                    }
                }
                return 'string';
            default:
                return $telegramType;
        }
    }

}
