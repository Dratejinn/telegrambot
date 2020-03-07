<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class PollAnswer
 * @package Telegram\API\Type
 * @property string $pollId
 * @property \Telegram\API\Type\User $user
 * @property int[] $optionIds
 */
class PollAnswer extends ABaseObject {

    public static function GetDatamodel() : array {
        $dataModel = [
            'pollId' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'poll_id'],
            'user' => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'user', 'class' => User::class],
            'optionIds' => ['type' => ABaseObject::T_ARRAY, 'optional' => FALSE, 'external' => 'option_ids']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }
}
