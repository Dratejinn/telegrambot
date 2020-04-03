<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class BotCommand
 * @package Telegram\API\Type
 *
 * @property string $command
 * @property string $description
 */
class BotCommand extends ABaseObject {

    public static function GetDatamodel() : array {
        $dataModel = [
            'command' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'command'],
            'description' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'description']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }
}
