<?php

declare(strict_types=1);

namespace Telegram\API\Games\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class Game extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'title'         => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'title'],
            'description'   => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'description'],
            'photo'         => ['type' => ABaseObject::T_ARRAY,  'optional' => FALSE, 'external' => 'photo'],
            'text'          => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,  'external' => 'text'],
            'textEntities'  => ['type' => ABaseObject::T_ARRAY,  'optional' => TRUE,  'external' => 'text_entities'],
            'animation'     => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,  'external' => 'animation', 'class' => Animation::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
