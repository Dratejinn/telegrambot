<?php

declare(strict_types = 1);


namespace Telegram\API\Passport;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class AFileHashPassportError
 * @package Telegram\API\Passport
 * @property string $fileHash
 */
abstract class AFileHashPassportError extends APassportError {
    public static function GetDatamodel() : array {
        $dataModel = [
            'fileHash' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'file_hash']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }


}
