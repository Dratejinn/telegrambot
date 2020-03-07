<?php

declare(strict_types = 1);

namespace Telegram\API\Passport\Error;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Passport\APassportError;

/**
 * Class PassportElementErrorDataField
 * @package Telegram\API\Passport\Error
 * @property string $fieldName
 * @property string $dataHash
 */
class PassportElementErrorDataField extends APassportError {

    const T_PERSONAL_DETAILS = 'personal_details';
    const T_PASSPORT = 'passport';
    const T_DRIVER_LICENSE = 'driver_license';
    const T_IDENTITY_CARD = 'identity_card';
    const T_INTERNAL_PASSPORT = 'internal_passport';
    const T_ADDRESS = 'address';

    public static function GetDatamodel() : array {
        $dataModel = [
            'fieldName' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'field_name'],
            'dataHash' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'data_hash']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        $this->source = 'data';
    }


}
