<?php

declare(strict_types = 1);


namespace Telegram\API\Passport;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class PassportData
 * @package Telegram\API\Passport
 * @property \Telegram\API\Passport\EncryptedPassportElement[] $data
 * @property \Telegram\API\Passport\EncryptedCredentials $credentials
 */
class PassportData extends ABaseObject {

    public static function GetDatamodel(): array {
        $dataModel = [
            'data' => ['type' => ABaseObject::T_ARRAY, 'optional' => FALSE, 'external' => 'data'],
            'credentials' => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'credentials', 'class' => EncryptedCredentials::class]
        ];

        return array_merge(parent::GetDatamodel(), $dataModel);
    }


}
