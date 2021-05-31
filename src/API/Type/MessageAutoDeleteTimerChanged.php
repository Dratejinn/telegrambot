<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class MessageAutoDeleteTimerChanged
 * @package Telegram\API\Type
 * @property int $messageAutoDeleteTime
 */
class MessageAutoDeleteTimerChanged extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'messageAutoDeleteTime' => ['type' => ABaseObject::T_INT, 'optional' => FALSE, 'external' => 'message_auto_delete_time']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
