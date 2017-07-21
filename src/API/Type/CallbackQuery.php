<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Method\AnswerCallbackQuery;
use Telegram\API\Bot;

/**
 * Class CallbackQuery
 * @package Telegram\API\Type
 * @property string id
 * @property \Telegram\API\Type\User from
 * @property null|\Telegram\API\Type\Message message
 * @property null|string inlineMessageId
 * @property null|string chatInstance
 * @property null|string data
 * @property null|string gameShortName
 */
class CallbackQuery extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'id';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'id'                => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'id'],
            'from'              => ['type' => ABaseObject::T_OBJECT,    'optional' => FALSE,    'external' => 'from',               'class' => User::class],
            'message'           => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'message',            'class' => Message::class],
            'inlineMessageId'   => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'inline_messsage_id'],
            'chatInstance'      => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'chat_instance'],
            'data'              => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'data'],
            'gameShortName'     => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'game_short_name']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * Answer this callback query with a text message
     * @param \Telegram\API\Bot $bot
     * @param string|NULL $text
     */
    public function answer(Bot $bot, string $text = NULL) {
        $answer = new AnswerCallbackQuery;
        $answer->callbackQueryId = $this->id;
        if ($text !== NULL) {
            $answer->text = $text;
        }
        $answer->call($bot);
    }
}
