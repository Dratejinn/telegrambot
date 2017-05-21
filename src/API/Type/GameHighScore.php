<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class GameHighScore extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'position' => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'position'],
            'user'     => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE,    'external' => 'user', 'class' => User::class],
            'score'    => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'score'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
