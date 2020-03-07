<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class File
 * @package Telegram\API\Type
 * @property string $fileId
 * @property string $fileUniqueId
 * @property null|int $fileSize
 * @property null|string $filePath
 */
class File extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'fileId';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $dataModel = [
            'fileId'        => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'file_id'],
            'fileUniqueId'  => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,    'external' => 'file_unique_id'],
            'fileSize'      => ['type' => ABaseObject::T_INT,    'optional' => TRUE,     'external' => 'file_size'],
            'filePath'      => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,     'external' => 'file_path']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }
}
