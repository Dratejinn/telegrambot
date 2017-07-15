<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultCachedMpeg4Gif
 * @package Telegram\API\InlineQuery\Type
 * @property string $mpg4FileId
 * @property null|string $caption
 */
class InlineQueryResultCachedMpeg4Gif extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'mpeg4FileId'   => ['type' => ABaseObject::T_STRING,  'optional' => FALSE,   'external' => 'mpeg4_file_id'],
            'caption'       => ['type' => ABaseObject::T_STRING,  'optional' => TRUE,    'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'mpeg4_gif';
    }
}
