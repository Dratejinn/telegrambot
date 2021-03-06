<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Type\MessageEntity;

/**
 * Class InputTextMessageContent
 * @package Telegram\API\InlineQuery\Type
 * @property string $messageText
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $entities
 * @property null|bool $disableWebPagePreview
 */
class InputTextMessageContent extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'messageText'           => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'message_text'],
            'parseMode'             => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'parse_mode'],
            'entities'              => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'entities'],
            'disableWebPagePreview' => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'disable_web_page_preview'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        if (isset($this->entities)) {
            $entities = [];
            foreach ($this->entities as $entity) {
                $entities[] = new MessageEntity($entity);
            }
            $this->entities = $entities;
        }
    }


}
