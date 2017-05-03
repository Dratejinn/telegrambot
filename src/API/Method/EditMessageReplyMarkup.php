<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

class EditMessageReplyMarkup extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'            => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'chat_id'],
            'messageId'         => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'message_id'],
            'inlineMessageId'   => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'inline_message_id'],
            'replyMarkup'       => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'reply_markup',       'class' => Type\InlineKeyboardMarkup::class],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function call(Bot $bot) {
        $reply = $bot->call('editMessageReplyMarkup', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if ($reply->result === TRUE) {
                    return TRUE;
                } else {
                    return new Type\Message($reply->result);
                }
            } else {
                if (isset($reply->description)) {
                    // throw new \Exception("Could not properly execute the request!\n\n" . $reply->description);
                    echo "Could not properly execute the request!\n\n" . $reply->description . PHP_EOL;
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
    }
}
