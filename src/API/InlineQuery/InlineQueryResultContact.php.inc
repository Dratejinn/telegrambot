<?php

declare(strict_types=1);

namespace Telegram\API\InlineQuery;

use Telegram\API\Base\Abstracts\{ABaseObject, AInlineQueryResult};

class InlineQueryResultContact extends AInlineQueryResult {

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

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'contact';
    }
}
