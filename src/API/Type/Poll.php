<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\API;
use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class Poll
 * @package Telegram\API\Type
 * @property string $id
 * @property string $question
 * @property \Telegram\API\Type\PollOption[] $options
 * @property int $totalVoterCount
 * @property bool $isClosed
 * @property bool $isAnonymous
 * @property string $type
 * @property null|int $correctOptionId
 * @property null|string $explanation
 * @property nulL|string $explanationEntities
 * @property null|int $openPeriod
 * @property null|int $closeDate
 */
class Poll extends ABaseObject {

    protected static $_IdProp = 'id';

    const T_REGULAR = 'regular';
    const T_QUIZ = 'quiz';

    public static function GetDatamodel() : array {
        $datamodel = [
            'id' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'id'],
            'question' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'question'],
            'options' => ['type' => ABaseObject::T_ARRAY, 'optional' => FALSE, 'external' => 'options'],
            'totalVoterCount' => ['type' => ABaseObject::T_INT, 'optional' => FALSE, 'external' => 'total_voter_count'],
            'isClosed' => ['type' => ABaseObject::T_BOOL, 'optional' => FALSE, 'external' => 'is_closed'],
            'isAnonymous' => ['type' => ABaseObject::T_BOOL, 'optional' => FALSE, 'external' => 'is_anonymous'],
            'type' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'type'],
            'allowsMultipleAnswers' => ['type' => ABaseObject::T_BOOL, 'optional' => FALSE, 'external' => 'allows_multiple_answers'],
            'correctOptionId' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'correct_option_id'],
            'explanation' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'explanation'],
            'explanationEntities' => ['type' => ABaseObject::T_ARRAY, 'optional' => TRUE, 'explanation_entities'],
            'openPeriod' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'open_period'],
            'closeDate' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'close_date']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        if (empty($this->id)) {
            $this->id = API::GenerateUUID();
        }

        if (isset($this->options)) {
            $options = [];
            foreach ($this->options as $option) {
                $options[] = new PollOption($option);
            }
            $this->options = $options;
        }
        if (isset($this->explanationEntities)) {
            $explanationEntities = [];
            foreach ($this->explanationEntities as $entity) {
                $explanationEntities[] = new MessageEntity($entity);
            }
            $this->explanationEntities = $explanationEntities;
        }
    }


}
