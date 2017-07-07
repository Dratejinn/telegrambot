<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

class InlineQueryResultArticle extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $datamodel = [
            'url'                   => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'url'],
            'hideUrl'               => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'hide_url'],
            'description'           => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'hide_url'],
            'thumb_url'             => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'hide_url'],
            'thumb_width'           => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'hide_url'],
            'thumb_height'          => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'hide_url'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'article';
    }
}
