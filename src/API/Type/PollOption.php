<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class PollOption
 * @package Telegram\API\Type
 * @property string $text
 * @property int $voterCount
 */
class PollOption extends ABaseObject {

    public static function GetDatamodel() : array {
        $dataModel = [
            'text' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'text'],
            'voterCount' => ['type' => ABaseObject::T_INT, 'optional' => FALSE, 'external' => 'voter_count']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }


}
