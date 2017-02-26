<?php

declare(strict_types = 1);

namespace Examples\Bot;

use Telegram\Bot\ABot as TBot;

class ExampleBot extends TBot {
    protected $_handlers = [
        self::UPDATE_TYPE_MESSAGE => Handlers\MessageHandler::class,
        self::UPDATE_TYPE_INLINEQUERY => Handlers\InlineQueryHandler::class
    ];

    public function __construct(string $token = NULL) {
        if ($token === NULL) {
            $token = '245725233:AAFghNdVDc-E6mwu2HOaYKgmmu3SF0RvLyM';
        }
        parent::__construct($token);
    }
}
