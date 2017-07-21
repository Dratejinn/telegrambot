<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultPhoto
 * @package Telegram\API\InlineQuery\Type
 * @property string $photoUrl
 * @property string $thumbUrl
 * @property null|int $photoWidth
 * @property null|int $photoHeight
 * @property null|string $description
 * @property null|string $caption
 */
class InlineQueryResultPhoto extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'photoUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'photo_url'],
            'thumbUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'thumb_url'],
            'photoWidth'    => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'photo_width'],
            'photoHeight'   => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'photo_height'],
            'description'   => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'description'],
            'caption'       => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'photo';
    }
}
