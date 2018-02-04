<?php

declare(strict_types = 1);

namespace Telegram\API\Base\Abstracts;

use Telegram\API\Base\InputFile;

/**
 * Class AInputMedia
 * @package Telegram\API\Base\Abstracts
 * @property string $type
 * @property string $media
 * @property null|string $caption
 */
class AInputMedia extends ABaseObject {

    /**
     * @var null|\Telegram\API\Base\InputFile
     */
    private $_attachment = NULL;

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'type'      => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'type'],
            'media'     => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'media'],
            'caption'   => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,  'external' => 'caption']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * Used to set 'media' as an attachedFile
     *
     * @param \Telegram\API\Base\InputFile $inputFile
     */
    public function setAttachment(InputFile $inputFile) {
        $this->_attachment = $inputFile;
    }

    /**
     * @return null|\Telegram\API\Base\InputFile
     */
    public function getAttachment() {
        return $this->_attachment;
    }

    /**
     * Used to check whether the input media has a file attached
     *
     * @return bool
     */
    public function hasAttachment() : bool {
        return $this->_attachment !== NULL;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function __set(string $name, $value) {
        if ($name == 'media' && $this->_attachment) {
            $this->_attachment = NULL;
        }
        parent::__set($name, $value);
    }
}
