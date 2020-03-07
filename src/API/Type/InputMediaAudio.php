<?php

declare(strict_types=1);


namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Abstracts\AInputMedia;
use Telegram\API\Base\InputFile;

/**
 * Class InputMediaAudio
 * @package Telegram\API\Type
 * @property null|int $duration
 * @property null|string|\Telegram\API\Base\InputFile $thumb
 * @property null|string $performer
 * @property null|string $title
 */
class InputMediaAudio extends AInputMedia {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'duration' => ['type' => ABaseObject::T_INT, 'optional' => TRUE, 'external' => 'duration'],
            'thumb' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT], 'optional' => TRUE, 'external' => 'thumb', 'class' => InputFile::class],
            'performer' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE, 'external' => 'performer'],
            'title' => ['type' => ABaseObject::T_STRING, 'optional' => TRUE]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * InputMediaAudio constructor.
     * @param \stdClass|NULL $payload
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'audio';
    }

}
