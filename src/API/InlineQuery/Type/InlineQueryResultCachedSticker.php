<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultCachedSticker
 * @package Telegram\API\InlineQuery\Type
 * @property string $stickerFileId
 */
class InlineQueryResultCachedSticker extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $parentModel = parent::GetDatamodel();
        unset($parentModel['title']);
        $datamodel = [
            'stickerFileId'   => ['type' => ABaseObject::T_STRING,  'optional' => FALSE,   'external' => 'sticker_file_id'],
        ];
        return array_merge($parentModel, $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'sticker';
    }
}
