<?php

declare(strict_types=1);

namespace Telegram\API\Base\Abstracts;

use Telegram\API\Type;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

abstract class ASend extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'                => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'chat_id'],
            'disableNotification'   => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'disable_notification'],
            'replyToMessageId'      => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'reply_to_message_id'],
            'replyMarkup'           => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'reply_markup',           'class' => [Type\InlineKeyboardMarkup::class, Type\ReplyKeyboardMarkup::class, Type\ReplyKeyboardRemove::class, Type\ForceReply::class]],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function call(Bot $bot) {
        $reply = $bot->call($this->_getApiCall(), $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return new Type\Message($reply->result);
            } else {
                if (isset($reply->description)) {
                    echo "Could not properly execute the request!\n\n" . $reply->description . PHP_EOL;
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
    }

    protected function _getApiCall() : string {
        return lcfirst((substr(static::class, strrpos(static::class, '\\') + 1)));
    }
}
