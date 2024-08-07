<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\API\Type;
use Telegram\Exception\OutboundException;

/**
 * Class EditMessageLiveLocation
 * @package Telegram\API\Method
 * @property null|float|int $chatId
 * @property null|int $messageId
 * @property null|string $inlineMessageId
 * @property float $latitude
 * @property float $longitude
 * @property null|float $horizontalAccuracy
 * @property null|int $heading
 * @property null|int $proximityAlertRadius
 * @property null|\Telegram\API\Type\InlineKeyboardMarkup $replyMarkup
 */
class EditMessageLiveLocation extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'chatId'                => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],   'optional' => TRUE,     'external' => 'chat_id'],
            'messageId'             => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,     'external' => 'message_id'],
            'inlineMessageId'       => ['type' => ABaseObject::T_STRING,                        'optional' => TRUE,     'external' => 'inline_message_id'],
            'latitude'              => ['type' => ABaseObject::T_FLOAT,                         'optional' => FALSE,    'external' => 'latitude'],
            'longitude'             => ['type' => ABaseObject::T_FLOAT,                         'optional' => FALSE,    'external' => 'longitude'],
            'horizontalAccuracy'    => ['type' => ABaseObject::T_FLOAT,                         'optional' => TRUE,     'external' => 'horizontal_accuracy'],
            'heading'               => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,     'external' => 'heading'],
            'proximityAlertRadius'  => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,     'external' => 'proximity_alert_radius'],
            'replyMarkup'           => ['type' => ABaseObject::T_OBJECT,                        'optional' => TRUE,     'external' => 'reply_markup',       'class' => Type\InlineKeyboardMarkup::class],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('editMessageLiveLocation', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if ($reply->result === TRUE) {
                    return TRUE;
                } else {
                    return new Type\Message($reply->result);
                }
            } elseif (isset($reply->description)) {
                throw new OutboundException($this, $reply, "Could not properly execute the request!\n" . $reply->description);
            }
        }
        throw new OutboundException($this, $reply, 'An unknown error has occurred!');
    }
}
