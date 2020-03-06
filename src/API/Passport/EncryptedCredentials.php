<?php

declare(strict_types = 1);


namespace Telegram\API\Passport;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class EncryptedCredentials
 * @package Telegram\API\Passport
 * @property string $data
 * @property string $hash
 * @property string $secret
 */
class EncryptedCredentials extends ABaseObject {

    public static function GetDatamodel(): array {
        $dataModel = [
            'data' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'data'],
            'hash' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'hash'],
            'secret' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'secret']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }
}
