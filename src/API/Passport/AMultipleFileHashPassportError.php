<?php

declare(strict_types = 1);


namespace Telegram\API\Passport;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class AMultipleFileHashPassportError
 * @package Telegram\API\Passport
 * @property string[] $fileHashes
 */
abstract class AMultipleFileHashPassportError extends APassportError {

    public static function GetDatamodel() : array {
        $dataModel = [
            'fileHashes' => ['type' => ABaseObject::T_ARRAY, 'optional' => FALSE, 'external' => 'file_hashes']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }


}
