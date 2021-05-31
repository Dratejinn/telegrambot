<?php

declare(strict_types = 1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Abstracts\ASend;

/**
 * Class SendPoll
 * @package Telegram\API\Method
 * @property string $question
 * @property string[] $options
 * @property null|bool $isAnonymous
 * @property null|string $type
 * @property null|bool $allowsMultipleAnswers
 * @property null|int $correctOptionId
 * @property null|string $explanation
 * @property null|string $explanationParseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $explanationEntities
 * @property null|int $openPeriod
 * @property null|int $closeDate
 * @property null|bool $isClosed
 */
class SendPoll extends ASend {

    const T_REGULAR = 'regular';
    const T_QUIZ = 'quiz';

    public static function GetDatamodel() : array {
        $datamodel = [
            'question' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'question'],
            'options' => ['type' => ABaseObject::T_ARRAY, 'optional' => FALSE, 'external' => 'options'],
            'isAnonymous' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'is_anonymous'],
            'type' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'type'],
            'allowsMultipleAnswers' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'allows_multiple_answers'],
            'correctOptionId' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'correct_option_id'],
            'explanation' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'explanation'],
            'explanationParseMode' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'explanation_parse_mode'],
            'explanationEntities' => ['type' => ABaseObject::T_ARRAY, 'optional' => TRUE, 'external' => 'explanation_entities'],
            'openPeriod' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'open_period'],
            'closeDate' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'close_date'],
            'isClosed' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'is_closed']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

}
