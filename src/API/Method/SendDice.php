<?php

declare(strict_types = 1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Abstracts\ASend;

/**
 * Class SendDice
 * @package Telegram\API\Method
 * @property null|string $emoji
 */
class SendDice extends ASend {

    public static function GetDatamodel() : array {
        $datamodel = [
            'emoji' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'emoji']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }


}
