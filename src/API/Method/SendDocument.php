<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Base\InputFile;

/**
 * Class SendDocument
 * @package Telegram\API\Method
 * @property string|\Telegram\API\Base\InputFile $document
 * @property null|string $caption
 */
class SendDocument extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'document'      => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => FALSE,    'external' => 'document',      'class' => InputFile::class],
            'caption'       => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'caption'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
