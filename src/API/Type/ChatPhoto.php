<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class ChatPhoto extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'smallFileId'    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,  'external' => 'small_file_id'],
            'bigFileId'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,  'external' => 'big_file_id'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
