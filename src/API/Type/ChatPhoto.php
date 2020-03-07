<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class ChatPhoto
 * @package Telegram\API\Type
 * @property string $smallFileId
 * @property string $smallFileUniqueId
 * @property string $bigFileId
 * @property string $bigFileUniqueId
 */
class ChatPhoto extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $dataModel = [
            'smallFileId'       => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'small_file_id'],
            'smallFileUniqueId' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'small_file_unique_id'],
            'bigFileId'         => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'big_file_id'],
            'bigFileUniqueId'   => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,   'external' => 'big_file_unique_id'],
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }
}
