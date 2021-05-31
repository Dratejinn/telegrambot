<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Base\InputFile;
use Telegram\API\Type\MessageEntity;

/**
 * Class SendDocument
 * @package Telegram\API\Method
 * @property string|\Telegram\API\Base\InputFile $document
 * @property null|string $caption
 * @property null|string $parseMode
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 * @property null|bool $disableContentTypeDetection
 */
class SendDocument extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'document'                      => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => FALSE,    'external' => 'document',      'class' => InputFile::class],
            'thumb'                         => ['type' => [ABaseObject::T_OBJECT, ABaseObject::T_STRING],   'optional' => TRUE,     'external' => 'thumb',         'class' => InputFile::class],
            'caption'                       => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'caption'],
            'parseMode'                     => ['type' => ABaseObject::T_STRING,                            'optional' => TRUE,     'external' => 'parse_mode'],
            'captionEntities'               => ['type' => ABaseObject::T_ARRAY,                             'optional' => TRUE,     'external' => 'caption_entities', 'class' => MessageEntity::class],
            'disableContentTypeDetection'   => ['type' => ABaseObject::T_BOOL,                              'optional' => TRUE,     'external' => 'disable_content_type_detection']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
