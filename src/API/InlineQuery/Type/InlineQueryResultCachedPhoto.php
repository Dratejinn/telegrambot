<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultCachedPhoto
 * @package Telegram\API\InlineQuery\Type
 * @property string $photoFileId
 * @property null|string $description
 * @property null|string $caption
 */
class InlineQueryResultCachedPhoto extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'photoFileId'   => ['type' => ABaseObject::T_STRING,  'optional' => FALSE,   'external' => 'photo_file_id'],
            'description'   => ['type' => ABaseObject::T_STRING,  'optional' => TRUE,    'external' => 'description'],
            'caption'       => ['type' => ABaseObject::T_STRING,  'optional' => TRUE,    'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'photo';
    }
}
