<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class MessageEntity
 * @package Telegram\API\Type
 * @property string $type
 * @property int $offset
 * @property int $length
 * @property null|string $url
 * @property null|\Telegram\API\Type\User $user
 */
class MessageEntity extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'type'   => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'type'],
            'offset' => ['type' => ABaseObject::T_INT,      'optional' => FALSE,    'external' => 'offset'],
            'length' => ['type' => ABaseObject::T_INT,      'optional' => FALSE,    'external' => 'length'],
            'url'    => ['type' => ABaseObject::T_STRING,   'optional' => TRUE,     'external' => 'url'],
            'user'   => ['type' => ABaseObject::T_OBJECT,   'optional' => TRUE,     'external' => 'user',   'class' => User::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
