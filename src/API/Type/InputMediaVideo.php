<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Abstracts\AInputMedia;
use Telegram\API\Base\InputFile;

/**
 * Class InputMediaVideo
 * @package Telegram\API\Type
 * @property null|int $width
 * @property null|int $height
 * @property null|int $duration
 * @property null|bool $supportsStreaming
 * @property null|string|\Telegram\API\Base\InputFile $thumb
 */
class InputMediaVideo extends AInputMedia {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'width' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'width'],
            'height' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'height'],
            'duration' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'duration'],
            'supportsStreaming' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'supports_streaming'],
            'thumb' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT], 'optional' => TRUE, 'external' => 'thumb', 'class' => InputFile::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * InputMediaVideo constructor.
     * @param \stdClass|NULL $payload
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'video';
    }
}
