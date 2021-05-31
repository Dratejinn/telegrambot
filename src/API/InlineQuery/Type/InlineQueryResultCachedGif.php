<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};
use Telegram\API\Type\MessageEntity;

/**
 * Class InlineQueryResultCachedGif
 * @package Telegram\API\InlineQuery\Type
 * @property string $gifFileId
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 */
class InlineQueryResultCachedGif extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'gifFileId'         => ['type' => ABaseObject::T_STRING,  'optional' => FALSE,   'external' => 'gif_file_id'],
            'caption'           => ['type' => ABaseObject::T_STRING,  'optional' => TRUE,    'external' => 'caption'],
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
