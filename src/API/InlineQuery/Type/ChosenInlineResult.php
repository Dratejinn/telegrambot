<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API;

/**
 * Class ChosenInlineResult
 * @package Telegram\API\InlineQuery\Type
 * @property string $resultId
 * @property \Telegram\API\Type\User $from
 * @property null|\Telegram\API\Type\Location $location
 * @property null|string $inlineMessageId
 * @property string $query
 */
class ChosenInlineResult extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'resultId';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'resultId'          => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'result_id'],
            'from'              => ['type' => ABaseObject::T_OBJECT,   'optional' => FALSE,    'external' => 'from',                'class' => API\Type\User::class],
            'location'          => ['type' => ABaseObject::T_OBJECT,   'optional' => TRUE,     'external' => 'location',            'class' => API\Type\Location::class],
            'inlineMessageId'   => ['type' => ABaseObject::T_STRING,   'optional' => TRUE,     'external' => 'inline_message_id'],
            'query'             => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'query'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
