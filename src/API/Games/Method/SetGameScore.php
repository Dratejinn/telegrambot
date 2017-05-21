<?php

declare(strict_types=1);

namespace Telegram\API\Games\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Type\InlineKeyboardMarkup;
use Telegram\Abstracts\Interfaces\IOutbound;

class SetGameScore extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $datamodel = [
            'userId'                => ['type' => ABaseObject::T_INT,       'optional' => FALSE, 'external' => 'user_id'],
            'score'                 => ['type' => ABaseObject::T_INT,       'optional' => FALSE, 'external' => 'score'],
            'force'                 => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,  'external' => 'force'],
            'disableEditMessage'    => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,  'external' => 'disable_edit_message'],
            'chatId'                => ['type' => ABaseObject::T_INT,       'optional' => TRUE,  'external' => 'chat_id'],
            'messageId'             => ['type' => ABaseObject::T_INT,       'optional' => TRUE,  'external' => 'message_id'],
            'inlineMessageId'       => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,  'external' => 'inline_message_id']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function call(Bot $bot) {
        $reply = $bot->call('SetGameScore', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if ($reply->result instanceof \stdClass) {
                    return new Type\Message($reply->result);
                } else {
                    return $reply->result;
                }
            } else {
                if (isset($reply->description)) {
                    echo "Could not properly execute the request!\n\n" . $reply->description . PHP_EOL;
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
    }
}
