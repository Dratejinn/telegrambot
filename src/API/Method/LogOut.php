<?php

declare(strict_types = 1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

class LogOut extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('logOut', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return TRUE;
            } else {
                if (isset($reply->description)) {
                    throw new \Exception("Could not properly execute the request!\n" . $reply->description);
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
        return NULL;
    }
}
