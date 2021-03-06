<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};
use Telegram\API\Type\MessageEntity;

/**
 * Class InlineQueryResultVideo
 * @package Telegram\API\InlineQuery\Type
 * @property string $videoUrl
 * @property string $mimeType
 * @property string $thumbUrl
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 * @property int $videoWidth
 * @property int $videoHeight
 * @property int $videoDuration
 * @property null|string $description
 */
class InlineQueryResultVideo extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'videoUrl'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'video_url'],
            'mimeType'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'mime_type'],
            'thumbUrl'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'thumb_url'],
            'caption'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'caption'],
            'parseMode'         => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'parse_mode'],
            'captionEntities'   => ['type' => ABaseObject::T_ARRAY,  'optional' => TRUE,     'external' => 'caption_entities'],
            'videoWidth'        => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'video_width'],
            'videoHeight'       => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'video_height'],
            'videoDuration'     => ['type' => ABaseObject::T_INT,    'optional' => FALSE,    'external' => 'video_duration'],
            'description'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'description'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'video';

        if (isset($this->captionEntities)) {
            $captionEntities = [];
            foreach ($this->captionEntities as $captionEntity) {
                $captionEntities[] = new MessageEntity($captionEntity);
            }
            $this->captionEntities = $captionEntities;
        }
    }
}
