<?php

declare(strict_types=1);


namespace Telegram\API\Stickers\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class StickerSet
 * @package Telegram\API\Stickers\Type
 * @property string $name
 * @property string $title
 * @property null|bool $isAnimated
 * @property null|bool $containsMasks
 * @property \Telegram\API\Stickers\Type\Sticker[] $stickers
 */
class StickerSet extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'name';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'name'          => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'name'],
            'title'         => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'title'],
            'isAnimated'    => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'is_animated'],
            'containsMasks' => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'containsMasks'],
            'stickers'      => ['type' => ABaseObject::T_ARRAY,     'optional' => FALSE,    'external' => 'stickers']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * Override to ensure stickers are of type sticker
     * StickerSet constructor.
     * @param \stdClass|NULL $payload
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $stickers = [];
        foreach ($this->stickers as $sticker) {
            $stickers[] = new Sticker($sticker);
        }
        $this->stickers = $stickers;
    }
}
