<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Base\InputFile;

class SendVideo extends ASend {

    public static function GetDatamodel() : array {
        $datamodel = [
            'video'     => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => FALSE,    'external' => 'video',      'class' => InputFile::class],
            'duration'  => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'duration'],
            'width'     => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'width'],
            'height'    => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'height'],
            'caption'   => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
