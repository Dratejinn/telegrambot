<?php

declare(strict_types=1);

namespace Telegram\API\Games\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class GameHighScore
 * @package Telegram\API\Games\Type
 * @property int $position
 * @property \Telegram\API\Type\User $user
 * @property int $score
 */
class GameHighScore extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'position' => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'position'],
            'user'     => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE,    'external' => 'user', 'class' => User::class],
            'score'    => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'score'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
