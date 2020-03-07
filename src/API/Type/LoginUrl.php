<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class LoginUrl
 * @package Telegram\API\Type
 * @property string $url
 * @property null|string $forwardText
 * @property null|string $botUsername
 * @property null|bool $requestWriteAccess
 */
class LoginUrl extends ABaseObject {

    public static function GetDatamodel() : array {
        $dataModel = [
            'url' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'url'],
            'forwardText' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'forward_text'],
            'botUsername' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'bot_username'],
            'requestWriteAccess' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'request_write_access']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }
}
