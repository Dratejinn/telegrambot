<?php

declare(strict_types=1);

namespace Telegram\API\Base\Abstracts;

use Telegram\API\InlineQuery;

abstract class AInlineQueryResult extends ABaseObject {

    protected static $_IdProp = 'id';

    public static function GetDatamodel() : array {
        $datamodel = [
            'type'                  => ['type' => ABaseObject::T_STRING,    'optional' => FALSE, 'external' => 'type'],
            'id'                    => ['type' => ABaseObject::T_STRING,    'optional' => FALSE, 'external' => 'id'],
            'title'                 => ['type' => ABaseObject::T_STRING,    'optional' => FALSE, 'external' => 'title'],
            'replyMarkup'           => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,  'external' => 'reply_markup',          'class' => Type\InlineKeyboardMarkup::class],
            'input_message_content' => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,  'external' => 'input_message_content', 'class' => [InlineQuery\InputTextMessageContent::class, InlineQuery\InputLocationMessageContent::class, InlineQuery\InputVenueMessageContent::class, InlineQuery\InputContactMessageContent::class]],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
