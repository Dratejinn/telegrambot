<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Base\InputFile;

class SendPhoto extends ASend {

    public static function GetDatamodel() : array {
        $datamodel = [
            'photo'     => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => FALSE,    'external' => 'photo',      'class' => InputFile::class],
            'caption'   => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
