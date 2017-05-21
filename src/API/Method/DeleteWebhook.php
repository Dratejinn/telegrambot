<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

class DeleteWebhook extends ABaseObject implements IOutbound {

    public function call(Bot $bot) {
        $reply = $bot->call('deleteWebhook', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return TRUE;
            }
        }
        return NULL;
    }
}
