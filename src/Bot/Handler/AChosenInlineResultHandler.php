<?php

declare(strict_types = 1);

namespace Telegram\Bot\Handler;

use Telegram\Bot\ABot;
use Telegram\API;
use Telegram\API\Method\SendMessage;

abstract class AChosenInlineResultHandler extends \Telegram\Bot\AHandler {

    protected $_chosenInlineResult = NULL;

    /**
     * @inheritdoc
     */
    public function __construct(API\Type\Update $update, ABot $bot) {
        parent::__construct($update, $bot);
        $this->_chosenInlineResult = $update->chosenInlineResult;
    }
}
