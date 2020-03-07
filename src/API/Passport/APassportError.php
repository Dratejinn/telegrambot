<?php

declare(strict_types = 1);


namespace Telegram\API\Passport;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class APassportError
 * @package Telegram\API\Passport
 * @property string $source
 * @property string $type
 * @property string $message
 */
abstract class APassportError extends ABaseObject {

    public static function GetDatamodel() : array {
        $dataModel = [
            'source'  => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'source'],
            'type' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'type'],
            'message' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'message']
        ];

        return array_merge(parent::GetDatamodel(), $dataModel);
    }

}
