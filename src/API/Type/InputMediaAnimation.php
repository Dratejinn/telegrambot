<?php

declare(strict_types=1);


namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Abstracts\AInputMedia;
use Telegram\API\Base\InputFile;

/**
 * Class InputMediaAnimation
 * @package Telegram\API\Type
 * @property null|int $width
 * @property null|int $height
 * @property null|int $duration
 * @property null|string|\Telegram\API\Base\InputFile $thumb
 */
class InputMediaAnimation extends AInputMedia {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'width' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'width'],
            'height' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'height'],
            'duration' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'duration'],
            'thumb' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT], 'optional' => TRUE, 'external' => 'thumb', 'class' => InputFile::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * InputMediaAnimation constructor.
     * @param \stdClass|NULL $payload
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'animation';
    }

}
