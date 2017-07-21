<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class UserProfilePhotos
 * @package Telegram\API\Type
 * @property int $totalCount
 * @property array $photos
 */
class UserProfilePhotos extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'totalCount'    => ['type' => ABaseObject::T_INT,    'optional' => FALSE,  'external' => 'total_count'],
            'photos'        => ['type' => ABaseObject::T_ARRAY,  'optional' => FALSE,  'external' => 'photos'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * UserProfilePhotos constructor.
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        if (isset($this->photos)) {
            $photos = [];
            foreach ($this->photos as $photoArray) {
                $photoArr = [];
                foreach ($photoArray as $photoSizeObj) {
                    $photoArr[] = new PhotoSize($photoSizeObj);
                }
                $photos[] = $buttonRow;
            }
            $this->photos = $photos;
        }
    }
}
