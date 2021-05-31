<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Type;

/**
 * Class InlineQuery
 * @package Telegram\API\InlineQuery\Type
 * @property string $id
 * @property \Telegram\API\Type\User $from
 * @property string $query
 * @property string $offset
 * @property null|string $chatType
 * @property null|\Telegram\API\Type\Location $location
 */
class InlineQuery extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'id';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'id'        => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'id'],
            'from'      => ['type' => ABaseObject::T_OBJECT,    'optional' => FALSE,    'external' => 'from',       'class' => Type\User::class],
            'query'     => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'query'],
            'offset'    => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'offset'],
            'chatType'  => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'chat_type'],
            'location'  => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'location',   'class' => Type\Location::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
