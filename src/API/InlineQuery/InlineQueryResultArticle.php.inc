<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult}

class InlineQueryResultArticle extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $datamodel = [
            'url'                   => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'url'],
            'hideUrl'               => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'hide_url'],
            'description'           => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'hide_url'],
            'thumb_url'             => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'hide_url'],
            'thumb_width'           => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'hide_url'],
            'thumb_height'          => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'hide_url'],
            'input_message_content' => ['type' => ABaseObject::T_OBJECT,    'optional' => FALSE,    'external' => 'input_message_content', 'class' => [InlineQuery\InputTextMessageContent::class, InlineQuery\InputLocationMessageContent::class, InlineQuery\InputVenueMessageContent::class, InlineQuery\InputContactMessageContent::class]],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'article';
    }
}