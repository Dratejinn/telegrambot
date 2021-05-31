<?php

declare(strict_types=1);

namespace Telegram\API\Payments\Method;

use Telegram\API\Base\Abstracts\{ABaseObject, ASend};

/**
 * Class SendInvoice
 * @package Telegram\API\Payments\Method
 * @property string $title
 * @property string $description
 * @property string $payload
 * @property string $providerToken
 * @property string $currency
 * @property \Telegram\API\Payments\Type\LabeledPrice[] $prices
 * @property null|int $maxTipAmount
 * @property null|int[] $suggestedTipAmounts
 * @property null|string $startParameter
 * @property null|string $providerData
 * @property null|string $photoUrl
 * @property null|int $photoSize
 * @property null|int $photoWidth
 * @property null|int $photoHeight
 * @property null|bool $needName
 * @property null|bool $needPhoneNumber
 * @property null|bool $needEmail
 * @property null|bool $needShippingAddress
 * @property null|bool $sendPhoneNumberToProvider
 * @property null|bool $sendEmailToProvider
 * @property null|bool $isFlexible
 */
class SendInvoice extends ASend {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'title'                     => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE, 'external' => 'title'],
            'description'               => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE, 'external' => 'description'],
            'payload'                   => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE, 'external' => 'payload'],
            'providerToken'             => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE, 'external' => 'provider_token'],
            'currency'                  => ['type' => ABaseObject::T_STRING,                        'optional' => FALSE, 'external' => 'currency'],
            'prices'                    => ['type' => ABaseObject::T_ARRAY,                         'optional' => FALSE, 'external' => 'prices'],
            'maxTipAmount'              => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,  'external' => 'max_tip_amount'],
            'suggestedTipAmounts'       => ['type' => ABaseObject::T_ARRAY,                         'optional' => TRUE,  'external' => 'suggested_tip_amounts'],
            'startParameter'            => ['type' => ABaseObject::T_STRING,                        'optional' => TRUE,  'external' => 'start_parameter'],
            'providerData'              => ['type' => ABaseObject::T_STRING,                        'optional' => TRUE,  'external' => 'provider_data'],
            'photoUrl'                  => ['type' => ABaseObject::T_STRING,                        'optional' => TRUE,  'external' => 'photo_url'],
            'photoSize'                 => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,  'external' => 'photo_size'],
            'photoWidth'                => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,  'external' => 'photo_width'],
            'photoHeight'               => ['type' => ABaseObject::T_INT,                           'optional' => TRUE,  'external' => 'photo_height'],
            'needName'                  => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'need_name'],
            'needPhoneNumber'           => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'need_phone_number'],
            'needEmail'                 => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'need_email'],
            'needShippingAddress'       => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'need_shipping_address'],
            'sendPhoneNumberToProvider' => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'send_phone_number_to_provider'],
            'sendEmailToProvider'       => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'send_email_to_provider'],
            'isFlexible'                => ['type' => ABaseObject::T_BOOL,                          'optional' => TRUE,  'external' => 'is_flexible']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
