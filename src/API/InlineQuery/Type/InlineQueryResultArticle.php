<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultArticle
 * @package Telegram\API\InlineQuery\Type
 * @property null|string $url
 * @property null|bool $hideUrl
 * @property null|string $description
 * @property null|string $thumbUrl
 * @property null|int $thumbWidth
 * @property null|int $thumbHeight
 */
class InlineQueryResultArticle extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'url'               => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'url'],
            'hideUrl'           => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'hide_url'],
            'description'       => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'description'],
            'thumbUrl'          => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'thumb_url'],
            'thumbWidth'        => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'thumb_width'],
            'thumbHeight'       => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'thumb_height'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'article';
    }
}
