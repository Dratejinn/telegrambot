<?php

declare(strict_types = 1);

namespace Telegram\Bot\Handler;

use Telegram\API\Type\Update;
use Telegram\Bot\ABot;
use Telegram\Bot\AHandler;

abstract class APollHandler extends AHandler {

    /**
     * @var null|\Telegram\API\Type\Poll
     */
    protected $_poll = NULL;

    /**
     * @inheritdoc
     */
    public function __construct(Update $update, ABot $bot) {
        parent::__construct($update, $bot);

        $this->_poll = $update->poll;
    }


}
