<?php

declare(strict_types=1);


namespace Telegram\API\Stickers\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Abstracts\ASend;
use Telegram\API\Base\InputFile;

/**
 * Class SendSticker
 * @package Telegram\API\Stickers\Method
 * @property string|\Telegram\API\Base\InputFile $sticker
 */
class SendSticker extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'sticker' => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT], 'optional' => FALSE, 'external' => 'sticker', 'class' => InputFile::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}