<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Base\InputFile;

class SendVoice extends ASend {

    public static function GetDatamodel() : array {
        $datamodel = [
            'voice'     => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => FALSE,    'external' => 'voice',      'class' => InputFile::class],
            'caption'   => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'caption'],
            'duration'  => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'duration'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
