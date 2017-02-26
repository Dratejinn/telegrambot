<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class File extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'fileId'    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'file_id'],
            'fileSize'  => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'file_size'],
            'filePath'  => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'file_path']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
