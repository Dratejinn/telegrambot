<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

class AnswerCallbackQuery extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $datamodel = [
            'callbackQueryId'   => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'callback_query_id'],
            'text'              => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'text'],
            'showAlert'         => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'show_alert'],
            'url'               => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'url'],
            'cacheTime'         => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'cache_time']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function call(Bot $bot) {
        $reply = $bot->call('answerCallbackQuery', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return TRUE;
            } else {
                if (isset($reply->description)) {
                    throw new \Exception("Could not properly execute the request!\n\n" . $reply->description);
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
    }
}
