<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class Video extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'fileId'    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'file_id'],
            'width'     => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'width'],
            'height'    => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'height'],
            'duration'  => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'duration'],
            'thumb'     => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,     'external' => 'thumb', 'class' => PhotoSize::class],
            'mimeType'  => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'mime_type'],
            'fileSize'  => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'file_size']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
