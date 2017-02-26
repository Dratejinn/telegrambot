<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

class InlineQueryResultCachedSticker extends AInlineQueryResult {

    public static function GetDatamodel() : array {
        $parentModel = parent::GetDatamodel();
        unset($parentModel['title']);
        $datamodel = [
            'stickerFileId'   => ['type' => ABaseObject::T_STRING,  'optional' => FALSE,   'external' => 'sticker_file_id'],
        ];
        return array_merge($parentModel, $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'sticker';
    }
}
