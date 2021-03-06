<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};
use Telegram\API\Type\MessageEntity;

/**
 * Class InlineQueryResultMpeg4Gif
 * @package Telegram\API\InlineQuery\Type
 * @property string $mpeg4url
 * @property string $thumbUrl
 * @property null|int $mpeg4Width
 * @property null|int $mpeg4Height
 * @property null|int $mpeg4Duration
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 */
class InlineQueryResultMpeg4Gif extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'mpeg4Url'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'mpeg4_url'],
            'thumbUrl'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'thumb_url'],
            'mpeg4Width'        => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'mpeg4_width'],
            'mpeg4Height'       => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'mpeg4_height'],
            'mpeg4Duration'     => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'mpeg4_duration'],
            'caption'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'caption'],
            'parseMode'         => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'parse_mode'],
            'captionEntities'   => ['type' => ABaseObject::T_ARRAY,  'optional' => TRUE,     'external' => 'caption_entities']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'mpeg4_gif';

        if (isset($this->captionEntities)) {
            $captionEntities = [];
            foreach ($this->captionEntities as $captionEntity) {
                $captionEntities[] = new MessageEntity($captionEntity);
            }
            $this->captionEntities = $captionEntities;
        }
    }
}
