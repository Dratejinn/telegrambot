<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class KeyboardButtonPollType extends ABaseObject {

    const T_QUIZ= 'quiz';
    const T_REGULAR = 'regular';

    public static function GetDatamodel() : array {
        $dataModel = [
            'type' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'type']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }
}
