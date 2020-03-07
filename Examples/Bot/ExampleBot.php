<?php

declare(strict_types = 1);

namespace Examples\Bot;

use Examples\Bot\Handlers\PollHandler;
use Telegram\Bot\ABot as TBot;

class ExampleBot extends TBot {

    const TOKEN = ''; //place your token here (optionally)

    protected $_handlers = [
        self::UPDATE_TYPE_MESSAGE => Handlers\MessageHandler::class,
        self::UPDATE_TYPE_INLINEQUERY => Handlers\InlineQueryHandler::class,
        self::UPDATE_TYPE_POLL => PollHandler::class
    ];

    public function __construct(string $token = NULL) {
        if ($token === NULL) {
            $token = self::TOKEN;
        }
        parent::__construct($token);
    }
}
