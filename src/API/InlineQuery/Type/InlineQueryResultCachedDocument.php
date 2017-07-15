<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultCachedDocument
 * @package Telegram\API\InlineQuery\Type
 * @property null|string $caption
 * @property string $documentFileId
 * @property null|string $description
 */
class InlineQueryResultCachedDocument extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'caption'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'caption'],
            'documentFileId'    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'document_file_id'],
            'description'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'description'],
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
