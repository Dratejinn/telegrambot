<?php

declare(strict_types = 1);

namespace Telegram\API\Base\Interfaces;

interface IOutbound {
    public function call(\Telegram\API\Bot $bot);
}
