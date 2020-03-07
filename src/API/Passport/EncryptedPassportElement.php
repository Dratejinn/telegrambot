<?php

declare(strict_types = 1);


namespace Telegram\API\Passport;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class EncryptedPassportElement
 * @package Telegram\API\Passport
 * @property string $type
 * @property null|string $data
 * @property null|string $phoneNumber
 * @property null|string $email
 * @property null|\Telegram\API\Passport\PassportFile[] $files
 * @property null|\Telegram\API\Passport\PassportFile $frontSide
 * @property null|\Telegram\API\Passport\PassportFile $reverseSide
 * @property null|\Telegram\API\Passport\PassportFile $selfie
 * @property null|\Telegram\API\Passport\PassportFile[] $translation
 * @property string $hash
 */
class EncryptedPassportElement extends ABaseObject {

    const T_PERSONAL_DETAILS = 'personal_details';
    const T_PASSPORT = 'passport';
    const T_DRIVER_LICENSE = 'driver_license';
    const T_IDENTITY_CARD = 'identity_card';
    const T_INTERNAL_PASSPORT = 'internal_passport';
    const T_ADDRESS = 'address';
    const T_UTILITY_BILL = 'utility_bill';
    const T_BANK_STATEMENT = 'bank_statement';
    const T_RENTAL_AGREEMENT = 'rental_agreement';
    const T_PASSPORT_REGISTRATION = 'passport_registration';
    const T_TEMPORARY_REGISTRATION = 'temporary_registration';
    const T_PHONE_NUMBER = 'phone_number';
    const T_EMAIL = 'email';

    public static function GetDatamodel() : array {
        $dataModel = [
            'type' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'type'],
            'data' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'data'],
            'phoneNumber' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'phone_number'],
            'email' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'email'],
            'files' => ['type' => ABaseObject::T_ARRAY, 'optional' => TRUE, 'external' => 'files'],
            'frontSide' => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE, 'external' => 'front_side', 'class' => PassportFile::class],
            'reverseSide' => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE, 'external' => 'reverse_side' ,'class' => PassportFile::class],
            'selfie' => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE, 'external' => 'selfie', 'class' => PassportFile::class],
            'translation' => ['type' => ABaseObject::T_ARRAY, 'optional' => TRUE, 'external' => 'translation'],
            'hash' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'hash']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        if (isset($this->files)) {
            $files = [];
            foreach ($this->files as $file) {
                $files[] = new PassportFile($file);
            }
            $this->files = $files;
        }

        if (isset($this->translation)) {
            $translation = [];
            foreach ($this->translation as $translation) {
                $translation = new PassportFile($translation);
            }
            $this->translation = $translation;
        }
    }
}
