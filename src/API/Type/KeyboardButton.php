<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class KeyboardButton
 * @package Telegram\API\Type
 * @property string $text
 * @property null|bool $requestContact
 * @property null|bool $requestLocation
 * @property null|\Telegram\API\Type\KeyboardButtonPollType $requestPoll
 */
class KeyboardButton extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $dataModel = [
            'text'              => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,   'external' => 'text'],
            'requestContact'    => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,    'external' => 'request_contact'],
            'requestLocation'   => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,    'external' => 'request_location'],
            'requestPoll'       => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,    'external' => 'request_poll', 'class' => KeyboardButtonPollType::class]
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }
}
