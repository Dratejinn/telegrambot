<?php

declare(strict_types = 1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Abstracts\ASend;

/**
 * Class CopyMessage
 * @package Telegram\API\Method
 * @property string|float|int $fromChatId
 * @property float|int $messageId
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 */
class CopyMessage extends ASend {

    public static function GetDatamodel() : array {
        $datamodel = [
            'fromChatId' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_FLOAT, ABaseObject::T_INT], 'optional' => FALSE, 'external' => 'from_chat_id'],
            'messageId' => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT], 'optional' => FALSE, 'external' => 'message_id'],
            'caption' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'caption'],
            'parseMode' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'parse_mode'],
            'captionEntities' => ['type' => ABaseObject::T_ARRAY, 'optional' => TRUE, 'external' => 'caption_entities']
        ];

        return array_merge(parent::GetDatamodel(), $datamodel);
    }


}
