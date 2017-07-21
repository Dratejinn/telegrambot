<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class PhotoSize
 * @package Telegram\API\Type
 * @property string $fileId
 * @property int $width
 * @property int $height
 * @property null|int fileSize
 */
class PhotoSize extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'fileId';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'fileId'    => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'file_id'],
            'width'     => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'offset'],
            'height'    => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'height'],
            'fileSize'  => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'file_size'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
