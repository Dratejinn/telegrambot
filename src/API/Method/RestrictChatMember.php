<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class RestrictChatMember
 * @package Telegram\API\Method
 * @property string|int|float $chatId
 * @property int $userId
 * @property null|int $untilDate
 * @property null|bool $canSendMessage
 * @property null|bool $canSendMediaMessages
 * @property null|bool $canSendOtherMessages
 * @property null|bool $canAddWebPagePreviews
 */
class RestrictChatMember extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'                => ['type' => [ABaseObject::T_STRING, ABaseObject::T_INT, ABaseObject::T_FLOAT],    'optional' => FALSE, 'external' => 'chat_id'],
            'userId'                => ['type' => ABaseObject::T_INT,                                                   'optional' => FALSE, 'external' => 'user_id'],
            'untilDate'             => ['type' => ABaseObject::T_INT,                                                   'optional' => TRUE,  'external' => 'until_date'],
            'canSendMessage'        => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_send_messages'],
            'canSendMediaMessages'  => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_send_media_messages'],
            'canSendOtherMessages'  => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_send_other_messages'],
            'canAddWebPagePreviews' => ['type' => ABaseObject::T_BOOL,                                                  'optional' => TRUE,  'external' => 'can_add_web_page_previews']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('restrictChatMember', $this);
        $arr = [];
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if (!empty($reply->result)) {
                    return $reply->result;
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
}
