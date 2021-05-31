<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Bot;

/**
 * Class SendMessage
 * @package Telegram\API\Method
 * @property string $text
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $entities
 * @property null|bool $disableWebPagePreview
 */
class SendMessage extends ASend {

    const PARSEMODE_MARKDOWN = 'Markdown';
    const PARSEMODE_HTML = 'HTML';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'text'                  => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'text'],
            'parseMode'             => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'parse_mode'],
            'entities'              => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'entities'],
            'disableWebPagePreview' => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'disable_web_page_preview'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
