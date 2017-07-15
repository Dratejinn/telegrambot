<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultCachedVideo
 * @package Telegram\API\InlineQuery\Type
 * @property null|string $caption
 * @property string $videoFileId
 * @property null|string $description
 */
class InlineQueryResultCachedVideo extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'caption'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'caption'],
            'videoFileId'       => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'video_file_id'],
            'description'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'description'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'video';
    }
}
