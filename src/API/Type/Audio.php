<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class Audio
 * @package Telegram\API\Type
 * @property string $fileId
 * @property string $fileUniqueId
 * @property int $duration
 * @property null|string $performer
 * @property null|string $title
 * @property null|string $mimeType
 * @property null|int $fileSize
 * @property null|\Telegram\API\Type\PhotoSize $thumb
 */
class Audio extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'fileId';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'fileId'        => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'file_id'],
            'fileUniqueId'  => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'file_unique_id'],
            'duration'      => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'duration'],
            'performer'     => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'performer'],
            'title'         => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'title'],
            'mimeType'      => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'mime_type'],
            'fileSize'      => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'file_size'],
            'thumb'         => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'thumb', 'class' => PhotoSize::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
