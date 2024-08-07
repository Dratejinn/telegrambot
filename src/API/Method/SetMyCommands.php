<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\Exception\OutboundException;

/**
 * Class GetFile
 * @package Telegram\API\Method
 * @property \Telegram\API\Type\BotCommand[] $commands
 */
class SetMyCommands extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'commands' => ['type' => ABaseObject::T_ARRAY, 'optional' => FALSE, 'external' => 'commands'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('setMyCommands', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return TRUE;
            } elseif (isset($reply->description)) {
                throw new OutboundException($this, $reply, "Could not properly execute the request!\n" . $reply->description);
            }
        }
        throw new OutboundException($this, $reply, 'An unknown error has occurred!');
    }
}
