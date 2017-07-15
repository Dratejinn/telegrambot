<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};

/**
 * Class SendContact
 * @package Telegram\API\Method
 * @property string $phoneNumber
 * @property string $firstName
 * @property null|string $lastName
 */
class SendContact extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'phoneNumber'   => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'phone_number'],
            'firstName'     => ['type' => ABaseObject::T_STRING,   'optional' => FALSE,    'external' => 'first_name'],
            'lastName'      => ['type' => ABaseObject::T_STRING,   'optional' => TRUE,     'external' => 'last_name'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
