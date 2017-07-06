<?php

declare(strict_types = 1);

namespace Telegram\db\Phinx;

use Phinx\Migration\AbstractMigration;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\Storage\Migrations\TelegramAdapter;

class TelegramMigration extends AbstractMigration {
    protected function _migrateTelegramClass(ABaseObject $telegramClass, bool $createOptionalColumns = TRUE, array $options = []) {
        $adapter = new TelegramAdapter($telegramClass);

        $tableName = $adapter->getClassBaseName();

        $table = $this->table($tableName);
        foreach ($adapter->getProperties($createOptionalColumns) as $property) {
            if ($adapter->getCustomFieldForProperty($property, 'optional') == TRUE) {
                $propOptions = ['null' => TRUE];
            } else {
                $propOptions = [];
            }
            $propType = $this->_getMySqlTypeForProperty($adapter, $property);
            if (isset($options[$propType])) {
                $propOptions = $options[$propType];
            }
            if ($property === 'id') {
                $property = 'telegram_id';
            }
            $table->addColumn($property, $propType, $propOptions);
            if ($property === 'telegram_id') {
                $table->addIndex(['telegram_id'], ['unique' => TRUE, 'name' => 'UNI_telegram_id']);
            }
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
                //ensure integer type when only boolean or integers are possible
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
