<?php

declare(strict_types = 1);

namespace Telegram\API\Passport\Error;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Passport\APassportError;

/**
 * Class PassportElementErrorUnspecified
 * @package Telegram\API\Passport\Error
 * @property string $elementHash
 */
class PassportElementErrorUnspecified extends APassportError {

    public static function GetDatamodel() : array {
        $dataModel = [
            'elementHash' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'element_hash']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        $this->source = 'unspecified';
    }


}
