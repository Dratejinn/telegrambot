<?php

declare(strict_types = 1);


namespace Telegram\API\Passport;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class PassportFile
 * @package Telegram\API\Passport
 * @property string $fileId
 * @property string $fileUniqueId
 * @property int $fileSize
 * @property int $fileDate
 */
class PassportFile extends ABaseObject {

    public static function GetDatamodel() : array {
        $datModel = [
            'fileId' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'file_id'],
            'fileUniqueId' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'file_unique_id'],
            'fileSize' => ['type' => ABaseObject::T_INT, 'optional' => FALSE, 'external' => 'file_size'],
            'fileDate' => ['type' => ABaseObject::T_INT, 'optional' => FALSE, 'external' => 'file_date']
        ];
        return array_merge(parent::GetDatamodel(), $datModel);
    }
}
