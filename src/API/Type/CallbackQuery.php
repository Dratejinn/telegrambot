<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class CallbackQuery extends ABaseObject {

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

    public function answer(\Telegram\API\Bot $bot, string $text = NULL) {
        $answer = new \Telegram\API\Method\AnswerCallbackQuery;
        $answer->callbackQueryId = $this->id;
        if ($text !== NULL) {
            $answer->text = $text;
        }
        $answer->call($bot);
    }
}
