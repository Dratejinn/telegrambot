<?php

declare(strict_types=1);

namespace Telegram\API\Base\Abstracts;

use Telegram\API\InlineQuery;
use Telegram\API\Type;

/**
 * Class AInlineQueryResult
 * @package Telegram\API\Base\Abstracts
 * @property string $type
 * @property string $id
 * @property string $title
 * @property null|\Telegram\API\Type\InlineKeyboardMarkup $replyMarkup
 * @property null|\Telegram\API\InlineQuery\Type\InputContactMessageContent|\Telegram\API\InlineQuery\Type\InputLocationMessageContent|\Telegram\API\InlineQuery\Type\InputVenueMessageContent|\Telegram\API\InlineQuery\Type\InputContactMessageContent $inputMessageContent
 */
abstract class AInlineQueryResult extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'id';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'type'                  => ['type' => ABaseObject::T_STRING,    'optional' => FALSE, 'external' => 'type'],
            'id'                    => ['type' => ABaseObject::T_STRING,    'optional' => FALSE, 'external' => 'id'],
            'title'                 => ['type' => ABaseObject::T_STRING,    'optional' => FALSE, 'external' => 'title'],
            'replyMarkup'           => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,  'external' => 'reply_markup',          'class' => Type\InlineKeyboardMarkup::class],
            'inputMessageContent'   => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,  'external' => 'input_message_content', 'class' => [InlineQuery\Type\InputTextMessageContent::class, InlineQuery\Type\InputLocationMessageContent::class, InlineQuery\Type\InputVenueMessageContent::class, InlineQuery\Type\InputContactMessageContent::class]],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
