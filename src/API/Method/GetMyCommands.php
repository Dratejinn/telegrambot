<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

class GetMyCommands extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('getMyCommands', $this);

        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                $commands = [];
                foreach ($reply->result as $res) {
                    $commands[] = new Type\BotCommand($res);
                }
                return $commands;
            }
        }
        return NULL;
    }
}
