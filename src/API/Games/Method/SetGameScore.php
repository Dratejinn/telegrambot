<?php

declare(strict_types=1);

namespace Telegram\API\Games\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Type;
use Telegram\API\Bot;

/**
 * Class SetGameScore
 * @package Telegram\API\Games\Method
 * @property int $userId
 * @property int $score
 * @property null|bool $force
 * @property null|bool $disableEditMessage
 * @property null|float|int $chatId
 * @property null|int $messageId
 * @property null|string $inlineMessageId
 */
class SetGameScore extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'userId'                => ['type' => ABaseObject::T_INT,                           'optional' => FALSE, 'external' => 'user_id'],
            'score'                 => ['type' => ABaseObject::T_INT,                           'optional' => FALSE, 'external' => 'score'],
            'force'                 => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'force'],
            'disableEditMessage'    => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'disable_edit_message'],
            'chatId'                => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],   'optional' => TRUE,  'external' => 'chat_id'],
            'messageId'             => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,  'external' => 'message_id'],
            'inlineMessageId'       => ['type' => ABaseObject::T_STRING,                        'optional' => TRUE,  'external' => 'inline_message_id']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
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
                    $bot->logAlert("Could not properly execute the request!\n\n" . $reply->description . PHP_EOL);
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
    }
}
