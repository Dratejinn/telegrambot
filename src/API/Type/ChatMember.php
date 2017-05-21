<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class ChatMember extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'user'   => ['type' => ABaseObject::T_OBJECT,    'optional' => FALSE,    'external' => 'user',   'class' => User::class],
            'status' => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'status'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
