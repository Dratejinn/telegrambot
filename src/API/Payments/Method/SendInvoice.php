<?php

declare(strict_types=1);

namespace Telegram\API\Payments\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Type\InlineKeyboardMarkup;

class SendInvoice extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'                => ['type' => ABaseObject::T_INT,    'optional' => FALSE, 'external' => 'chat_id'],
            'title'                 => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'title'],
            'description'           => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'description'],
            'payload'               => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'payload'],
            'providerToken'         => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'provider_token'],
            'startParameter'        => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'start_parameter'],
            'currency'              => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'currency'],
            'prices'                => ['type' => ABaseObject::T_ARRAY,  'optional' => FALSE, 'external' => 'prices'],
            'photoUrl'              => ['type' => ABaseObject::T_STRING, 'optional' => TRUE,  'external' => 'photo_url'],
            'photoSize'             => ['type' => ABaseObject::T_INT,    'optional' => TRUE,  'external' => 'photo_size'],
            'photoWidth'            => ['type' => ABaseObject::T_INT,    'optional' => TRUE,  'external' => 'photo_width'],
            'photoHeight'           => ['type' => ABaseObject::T_INT,    'optional' => TRUE,  'external' => 'photo_height'],
            'needName'              => ['type' => ABaseObject::T_BOOL,   'optional' => TRUE,  'external' => 'need_name'],
            'needPhoneNumber'       => ['type' => ABaseObject::T_BOOL,   'optional' => TRUE,  'external' => 'need_phone_number'],
            'needEmail'             => ['type' => ABaseObject::T_BOOL,   'optional' => TRUE,  'external' => 'need_email'],
            'needShippingAddress'   => ['type' => ABaseObject::T_BOOL,   'optional' => TRUE,  'external' => 'need_shipping_address'],
            'isFlexible'            => ['type' => ABaseObject::T_BOOL,   'optional' => TRUE,  'external' => 'is_flexible'],
            'disableNotification'   => ['type' => ABaseObject::T_BOOL,   'optional' => TRUE,  'external' => 'disable_notification'],
            'replyToMessageId'      => ['type' => ABaseObject::T_INT,    'optional' => TRUE,  'external' => 'reply_to_message_id'],
            'replyMarkup'           => ['type' => ABaseObject::T_OBJECT, 'optional' => TRUE,  'external' => 'reply_markup',         'class' => InlineKeyboardMarkup::class],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
