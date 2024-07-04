<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\Exception\OutboundException;

/**
 * Class AnswerCallbackQuery
 * @package Telegram\API\Method
 * @property string $callbackQueryId
 * @property null|string $text
 * @property null|bool $showAlert
 * @property null|string $url
 * @property null|int $cacheTime
 */
class AnswerCallbackQuery extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('answerCallbackQuery', $this);
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
