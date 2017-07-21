<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultDocument
 * @package Telegram\API\InlineQuery\Type
 * @property null|string $caption
 * @property string $documentUrl
 * @property string $mimeType
 * @property null|string $description
 * @property null|string $thumbUrl
 * @property null|int $thumbWidth
 * @property null|int $thumbHeight
 */
class InlineQueryResultDocument extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'caption'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'caption'],
            'documentUrl'   => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'document_url'],
            'mimeType'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'mime_type'],
            'description'   => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'description'],
            'thumbUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'thumb_url'],
            'thumbWidth'    => ['type' => ABaseObject::T_INT,    'optional' => TRUE,    'external' => 'thumb_width'],
            'thumbHeight'   => ['type' => ABaseObject::T_INT,    'optional' => TRUE,    'external' => 'thumb_height']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'document';
    }
}
