<?php

declare(strict_types = 1);

namespace Telegram\db\Phinx;

use Phinx\Migration\AbstractMigration;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\Storage\Migrations\TelegramAdapter;

class TelegramMigration extends AbstractMigration {

    /**
     * Migrate the provided Telegram class
     * @param \Telegram\API\Base\Abstracts\ABaseObject $telegramClass
     * @param bool $createOptionalColumns
     * @param array $options
     */
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
                //ensure that length is sufficient for long id's (like with channels);
                if ($propType === 'integer') {
                    $propType = 'biginteger';
                }
            }
            $table->addColumn($property, $propType, $propOptions);
            if ($property === 'telegram_id') {
                $table->addIndex(['telegram_id'], ['unique' => TRUE, 'name' => 'UNI_telegram_id']);
            }
        }
        $table->create();
    }

    /**
     * Get the MySQL type for given property
     * @param \Telegram\Storage\Migrations\TelegramAdapter $adapter
     * @param string $property
     * @return mixed|string
     */
    protected function _getMySqlTypeForProperty(TelegramAdapter $adapter, string &$property) {
        $telegramType = $adapter->getTypeForProperty($property);

        //multiple types possible so get the best possible type
        if (is_array($telegramType) && count($telegramType) == 1) {
            $telegramType = $telegramType[0];
        }
        if (is_array($telegramType)) {
            if (in_array(ABaseObject::T_ARRAY, $telegramType) || in_array(ABaseObject::T_OBJECT, $telegramType)) {
                return 'string';
            } elseif ((in_array(ABaseObject::T_BOOL, $telegramType) || in_array(ABaseObject::T_INT, $telegramType)) && count($telegramType) == 2) {
                //ensure integer type when only boolean or integers are possible
                return ABaseObject::T_INT;
            } elseif ((in_array(ABaseObject::T_FLOAT, $telegramType) || in_array(ABaseObject::T_INT, $telegramType)) && count($telegramType) == 2) {
                return ABaseObject::T_FLOAT;
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
