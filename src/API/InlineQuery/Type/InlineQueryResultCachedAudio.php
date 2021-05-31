<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};
use Telegram\API\Type\MessageEntity;

/**
 * Class InlineQueryResultCachedAudio
 * @package Telegram\API\InlineQuery\Type
 * @property null|string $caption
 * @property string $audioFileId
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 */
class InlineQueryResultCachedAudio extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $parentModel = parent::GetDatamodel();
        unset($parentModel['title']);
        $datamodel = [
            'caption'           => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'caption'],
            'parseMode'         => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,    'external' => 'parse_mode'],
            'captionEntities'   => ['type' => ABaseObject::T_ARRAY,  'optional' => TRUE,    'external' => 'caption_entities'],
            'audioFileId'       => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'audio_file_id']
        ];
        return array_merge($parentModel, $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'audio';

        if (isset($this->captionEntities)) {
            $captionEntities = [];
            foreach ($this->captionEntities as $captionEntity) {
                $captionEntities[] = new MessageEntity($captionEntity);
            }
            $this->captionEntities = $captionEntities;
        }
    }
}
