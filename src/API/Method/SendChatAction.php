<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Bot;

/**
 * Class SendChatAction
 * @package Telegram\API\Method
 * @property string|int|float $chatId
 * @property string $action
 */
class SendChatAction extends ABaseObject {

    const ACTION_UPLOAD_PHOTO       = 'upload_photo';
    const ACTION_RECORD_VIDEO       = 'record_video';
    const ACTION_TYPING             = 'typing';
    const ACTION_UPLOAD_VIDEO       = 'upload_video';
    const ACTION_RECORD_AUDIO       = 'record_audio';
    const ACTION_UPLOAD_AUDIO       = 'upload_audio';
    const ACTION_UPLOAD_DOCUMENT    = 'upload_document';
    const ACTION_FIND_LOCATION      = 'find_location';
    const ACTION_RECORD_VIDEO_NOTE  = 'record_video_note';
    const ACTION_UPLOAD_VIDEO_NOTE  = 'upload_video_note';
    const ACTION_RECORD_VOICE       = 'record_voice';
    const ACTION_UPLOAD_VOICE       = 'upload_voice';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'     => ['type' => [ABaseObject::T_STRING, ABaseObject::T_INT, ABaseObject::T_FLOAT],   'optional' => FALSE,    'external' => 'chat_id'],
            'action'     => ['type' => ABaseObject::T_STRING,                                               'optional' => FALSE,    'external' => 'action'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('sendChatAction', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return $reply->result;
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
