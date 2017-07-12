<?php

declare(strict_types = 1);

namespace Telegram\API\Base\Interfaces;

use Telegram\API\Bot;

interface IOutbound {

    /**
     * @param \Telegram\API\Bot $bot
     * @return mixed
     */
    public function call(Bot $bot);
}
