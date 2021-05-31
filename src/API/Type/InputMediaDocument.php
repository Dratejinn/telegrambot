<?php

declare(strict_types=1);


namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Abstracts\AInputMedia;
use Telegram\API\Base\InputFile;

/**
 * Class InputMediaDocument
 * @package Telegram\API\Type
 * @property null|string|\Telegram\API\Base\InputFile $thumb
 * @property null|bool $disableContentTypeDetection
 */
class InputMediaDocument extends AInputMedia {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'thumb' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT], 'optional' => TRUE, 'external' => 'thumb', 'class' => InputFile::class],
            'disableContentTypeDetection'   => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'disable_content_type_detection']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * InputMediaDocument constructor.
     * @param \stdClass|NULL $payload
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'document';
    }

}
