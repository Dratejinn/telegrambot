<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class VoiceChatEnded extends ABaseObject {
    public static function GetDatamodel() : array {
        $datamodel = [
            'duration' => ['type' => ABaseObject::T_INT, 'optional' => FALSE, 'external' => 'duration']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
