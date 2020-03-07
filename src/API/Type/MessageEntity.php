<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class MessageEntity
 * @package Telegram\API\Type
 * @property string $type
 * @property int $offset
 * @property int $length
 * @property null|string $url
 * @property null|\Telegram\API\Type\User $user
 * @property string $language
 */
class MessageEntity extends ABaseObject {


    const T_MENTION = 'mention';
    const T_HASHTAG = 'hashtag';
    const T_CASHTAG = 'cashtag';
    const T_BOT_CMD = 'bot_command';
    const T_URL = 'url';
    const T_EMAIL = 'email';
    const T_PHONE_NUMBER = 'phone_number';
    const T_BOLD = 'bold';
    const T_ITALIC = 'italic';
    const T_CODE = 'code';
    const T_CODE_PRE = 'pre';
    const T_TEXT_LINK = 'text_link';
    const T_TEXT_MENTION = 'text_mention';
    const T_UNDERLINE = 'underline';
    const T_STRIKETHROUGH = 'strikethrough';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $dataModel = [
            'type'      => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'type'],
            'offset'    => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'offset'],
            'length'    => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'length'],
            'url'       => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'url'],
            'user'      => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'user',   'class' => User::class],
            'language'  => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'language']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }
}
