<?php

declare(strict_types = 1);

namespace Telegram\Bot\Handler;

use Telegram\Bot\ABot;
use Telegram\API;
use Telegram\API\InlineQuery;

abstract class AInlineQueryHandler extends \Telegram\Bot\AHandler {

    /**
     * @var \Telegram\API\InlineQuery\Type\InlineQuery
     */
    protected $_inlineQuery = NULL;

    /**
     * @inheritdoc
     */
    public function __construct(API\Type\Update $update, ABot $bot) {
        parent::__construct($update, $bot);
        $this->_inlineQuery = $update->inlineQuery;
    }

    /**
     * Creates an InlineQuery answer for the InlineQuery which should be responded to
     * @return \Telegram\API\InlineQuery\Method\AnswerInlineQuery
     */
    public function createAnswer() : InlineQuery\Method\AnswerInlineQuery {
        $answer = new InlineQuery\Method\AnswerInlineQuery;
        $answer->inlineQueryId = $this->_inlineQuery->id;
        return $answer;
    }

    /**
     * calls AnswerInlineQuery with the apiBot
     * @param \Telegram\API\InlineQuery\Method\AnswerInlineQuery $answerInlineQuery
     */
    public function sendAnswer(InlineQuery\Method\AnswerInlineQuery $answerInlineQuery) {
        $answerInlineQuery->call($this->_apiBot);
    }

    /**
     * Generates a universally unique identifier
     *
     * @deprecated use \Telegram\API\API::GenerateUUID instead
     *
     * @return string
     */
    public static function GenerateId() : string {
        return API\API::GenerateUUID();
    }
}
