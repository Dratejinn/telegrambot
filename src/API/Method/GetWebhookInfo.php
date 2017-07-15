<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\API\Type;

class GetWebhookInfo extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('getWebhookInfo', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return new Type\WebhookInfo($reply->result);
            }
        }
        return NULL;
    }
}
