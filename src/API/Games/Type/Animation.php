<?php

declare(strict_types=1);

namespace Telegram\API\Games\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class Animation extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'fileId'        => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'file_id'],
            'thumb'         => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,  'external' => 'thumb',    'class' => PhotoSize::class],
            'fileName'      => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,  'external' => 'file_name'],
            'mimeType'      => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,  'external' => 'mime_type'],
            'fileSize'      => ['type' => ABaseObject::T_INT,    'optional' => TRUE,  'external' => 'file_size'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
