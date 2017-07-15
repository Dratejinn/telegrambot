<?php

declare(strict_types=1);

namespace Telegram\API\Payments\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};
use Telegram\API\Type\InlineKeyboardMarkup;

/**
 * Class SendInvoice
 * @package Telegram\API\Payments\Method
 * @property string $title
 * @property string $description
 * @property string $payload
 * @property string $providerToken
 * @property string $startParameter
 * @property string $currency
 * @property \Telegram\API\Payments\Type\LabeledPrice[] $prices
 * @property null|string $photoUrl
 * @property null|int $photoSize
 * @property null|int $photoWidth
 * @property null|int $photoHeight
 * @property null|bool $needName
 * @property null|bool $needPhoneNumber
 * @property null|bool $needEmail
 * @property null|bool $needShippingAddress
 * @property null|bool $isFlexible
 */
class SendInvoice extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'title'                 => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE, 'external' => 'title'],
            'description'           => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE, 'external' => 'description'],
            'payload'               => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE, 'external' => 'payload'],
            'providerToken'         => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE, 'external' => 'provider_token'],
            'startParameter'        => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE, 'external' => 'start_parameter'],
            'currency'              => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE, 'external' => 'currency'],
            'prices'                => ['type' => ABaseObject::T_ARRAY,                         'optional' => FALSE, 'external' => 'prices'],
            'photoUrl'              => ['type' => ABaseObject::T_STRING,                        'optional' => TRUE,  'external' => 'photo_url'],
            'photoSize'             => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,  'external' => 'photo_size'],
            'photoWidth'            => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,  'external' => 'photo_width'],
            'photoHeight'           => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,  'external' => 'photo_height'],
            'needName'              => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'need_name'],
            'needPhoneNumber'       => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'need_phone_number'],
            'needEmail'             => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'need_email'],
            'needShippingAddress'   => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'need_shipping_address'],
            'isFlexible'            => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'is_flexible']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
