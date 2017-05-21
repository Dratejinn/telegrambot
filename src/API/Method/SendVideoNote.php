<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Base\InputFile;

class SendVideoNote extends ASend {

    public static function GetDatamodel() : array {
        $datamodel = [
            'videoNote' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => FALSE,    'external' => 'video_note',      'class' => InputFile::class],
            'duration'  => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'duration'],
            'length'    => ['type' => ABaseObject::T_INT,                               'optional' => TRUE,     'external' => 'length'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
