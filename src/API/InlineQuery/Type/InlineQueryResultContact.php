<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery\Type;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

/**
 * Class InlineQueryResultContact
 * @package Telegram\API\InlineQuery\Type
 * @property string $phoneNumber
 * @property string $firstName
 * @property null|string $lastName
 * @property null|string $thumburl
 * @property null|int $thumbWidth
 * @property null|int $thumbHeight
 */
class InlineQueryResultContact extends AInlineQueryResult {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'phoneNumber'   => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,  'external' => 'phone_number'],
            'firstName'     => ['type' => ABaseObject::T_STRING, 'optional' => FALSE,  'external' => 'first_name'],
            'lastName'      => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,   'external' => 'last_name'],
            'thumbUrl'      => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,   'external' => 'thumb_url'],
            'thumbWidth'    => ['type' => ABaseObject::T_INT,    'optional' => TRUE,   'external' => 'thumb_width'],
            'thumbHeight'   => ['type' => ABaseObject::T_INT,    'optional' => TRUE,   'external' => 'thumb_height']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'contact';
    }
}
