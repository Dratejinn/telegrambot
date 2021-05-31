<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};
use Telegram\API\Type\MessageEntity;

/**
 * Class InlineQueryResultPhoto
 * @package Telegram\API\InlineQuery\Type
 * @property string $photoUrl
 * @property string $thumbUrl
 * @property null|int $photoWidth
 * @property null|int $photoHeight
 * @property null|string $description
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 */
class InlineQueryResultPhoto extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'photoUrl'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'photo_url'],
            'thumbUrl'          => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'thumb_url'],
            'photoWidth'        => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'photo_width'],
            'photoHeight'       => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'photo_height'],
            'description'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'description'],
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
        $this->type = 'photo';

        if (isset($this->captionEntities)) {
            $captionEntities = [];
            foreach ($this->captionEntities as $captionEntity) {
                $captionEntities[] = new MessageEntity($captionEntity);
            }
            $this->captionEntities = $captionEntities;
        }
    }
}
