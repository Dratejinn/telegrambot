<?php

declare(strict_types=1);

namespace Telegram\API\Base\Abstracts;

use Telegram\API\Type;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class ASend
 * @package Telegram\API\Base\Abstracts
 * @property string|int|float $chatId
 * @property null|bool $disableNotification
 * @property null|int $replyToMessageId
 * @property null|bool $allowSendingWithoutReply
 * @property null|\Telegram\API\Type\InlineKeyboardMarkup|\Telegram\API\Type\ReplyKeyboardMarkup|\Telegram\API\Type\ReplyKeyboardRemove|\Telegram\API\Type\ForceReply $replyMarkup
 */
abstract class ASend extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'                    => ['type' => [ABaseObject::T_INT, ABaseObject::T_STRING, ABaseObject::T_FLOAT], 'optional' => FALSE,    'external' => 'chat_id'],
            'disableNotification'       => ['type' => ABaseObject::T_BOOL,                                               'optional' => TRUE,     'external' => 'disable_notification'],
            'replyToMessageId'          => ['type' => ABaseObject::T_INT,                                                'optional' => TRUE,     'external' => 'reply_to_message_id'],
            'allowSendingWithoutReply'  => ['type' => ABaseObject::T_BOOL,                                               'optional' => TRUE,     'external' => 'allow_sending_without_reply'],
            'replyMarkup'               => ['type' => ABaseObject::T_OBJECT,                                             'optional' => TRUE,     'external' => 'reply_markup', 'class' => [Type\InlineKeyboardMarkup::class, Type\ReplyKeyboardMarkup::class, Type\ReplyKeyboardRemove::class, Type\ForceReply::class]],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     * @param \Telegram\API\Bot $bot
     * @return \Telegram\API\Type\Message|\stdClass
     * @throws \Exception
     */
    public function call(Bot $bot) {
        $reply = $bot->call($this->_getApiCall(), $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return new Type\Message($reply->result);
            } else {
                if (isset($reply->description)) {
                    $bot->logAlert("Could not properly execute the request!\n\n" . $reply->description . PHP_EOL);
                }
                return $reply;
            }
        } else {
            throw new \Exception('An unknown error has occurred!');
        }
    }

    /**
     * Used to get the API call from the object
     * @return string
     */
    protected function _getApiCall() : string {
        return lcfirst((substr(static::class, strrpos(static::class, '\\') + 1)));
    }
}
