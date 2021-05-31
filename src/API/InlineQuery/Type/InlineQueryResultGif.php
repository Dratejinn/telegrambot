<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};
use Telegram\API\Type\MessageEntity;

/**
 * Class InlineQueryResultGif
 * @package Telegram\API\InlineQuery\Type
 * @property string $gifUrl
 * @property null|int $gifDuration
 * @property string $thumbUrl
 * @property null|int $gifWidth
 * @property null|int $gifHeight
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 */
class InlineQueryResultGif extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'gifUrl'        => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'gif_url'],
            'gifDuration'   => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'gif_duration'],
            'thumbUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'thumb_url'],
            'gifWidth'      => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'gif_width'],
            'gifHeight'     => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'gif_height'],
            'caption'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'caption'],
            'parseMode'         => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,  'external' => 'parse_mode'],
            'captionEntities'   => ['type' => ABaseObject::T_ARRAY,  'optional' => TRUE,  'external' => 'caption_entities']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'gif';

        if (isset($this->captionEntities)) {
            $captionEntities = [];
            foreach ($this->captionEntities as $captionEntity) {
                $captionEntities[] = new MessageEntity($captionEntity);
            }
            $this->captionEntities = $captionEntities;
        }
    }
}
