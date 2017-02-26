<?php

declare(strict_types = 1);

namespace Telegram\Bot\Handler;

use Telegram\Bot\ABot;
use Telegram\API;
use Telegram\API\InlineQuery;

abstract class AInlineQueryHandler extends \Telegram\Bot\AHandler {

    protected $_inlineQuery = NULL;

    public function __construct(API\Type\Update $update, ABot $bot) {
        parent::__construct($update, $bot);
        $this->_inlineQuery = $update->inlineQuery;
    }

    public function createAnswer() : InlineQuery\AnswerInlineQuery {
        $answer = new InlineQuery\AnswerInlineQuery;
        $answer->inlineQueryId = $this->_inlineQuery->id;
        return $answer;
    }

    public function sendAnswer(InlineQuery\AnswerInlineQuery $answerInlineQuery) {
        $answerInlineQuery->call($this->_bot);
    }

    public static function GenerateId() : string {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
