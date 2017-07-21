<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class Document
 * @package Telegram\API\Type
 * @property string $fileId
 * @property null|\Telegram\API\Type\PhotoSize $thumb
 * @property null|string $fileName
 * @property null|string $mimeType
 * @property null|int $fileSize
 */
class Document extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'fileId';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'fileId'    => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'file_id'],
            'thumb'     => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,     'external' => 'thumb', 'class' => PhotoSize::class],
            'fileName'  => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'file_name'],
            'mimeType'  => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'mime_type'],
            'fileSize'  => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'file_size']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
