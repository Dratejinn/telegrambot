<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class VoiceChatScheduled
 * @package Telegram\API\Type
 * @property int $startDate
 */
class VoiceChatScheduled extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'startDate' => ['type' => ABaseObject::T_INT, 'optional' => FALSE, 'external' => 'start_date']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
