<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\API\Type\Message;

/**
 * Class SendMediaGroup
 * @package Telegram\API\Method
 * @property int|string|float $chatId
 * @property \Telegram\API\Base\Abstracts\AInputMedia[]
 * @property null|bool $disableNotification
 * @property null|int $replyToMessageId
 * @property null|bool $allowSendingWithoutReply
 */
class SendMediaGroup extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'chatId'                    => ['type' => [ABaseObject::T_INT, ABaseObject::T_STRING, ABaseObject::T_FLOAT], 'optional' => FALSE,    'external' => 'chat_id'],
            'media'                     => ['type' => ABaseObject::T_ARRAY,                                              'optional' => FALSE,    'external' => 'media'],
            'disableNotification'       => ['type' => ABaseObject::T_BOOL,                                               'optional' => TRUE,     'external' => 'disable_notification'],
            'replyToMessageId'          => ['type' => ABaseObject::T_INT,                                                'optional' => TRUE,     'external' => 'reply_to_message_id'],
            'allowSendingWithoutReply'  => ['type' => ABaseObject::T_BOOL,                                               'optional' => TRUE,     'external' => 'allow_sending_without_reply']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * Used to send the request to the Telegram bot API
     *
     * @param \Telegram\API\Bot $bot
     * @return mixed
     * @throws \Exception
     */
    public function call(Bot $bot) {
        $reply = $bot->call('sendMediaGroup', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if (!empty($reply->result)) {
                    $ret = [];
                    foreach ($reply->result as $message) {
                        $ret[] = new Message($message);
                    }
                    return $ret;
                }
            } else {
                if (isset($reply->description)) {
                    throw new \Exception("Could not properly execute the request!\n" . $reply->description);
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
    }

    /**
     * Overload to ensure proper json encoding of media
     * @return array
     */
    public function getMultipartFormData(): array {
        $multiPart = parent::getMultipartFormData();
        $multiPart['media'] = \json_encode($multiPart['media']);
        return $multiPart;
    }
}
