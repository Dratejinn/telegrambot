<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\InlineQuery\Type\{ChosenInlineResult, InlineQuery};
use Telegram\API\Payments\Type\{PreCheckoutQuery, ShippingQuery};
use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class Update
 * @package Telegram\API\Type
 * @property float|int $id
 * @property null|\Telegram\API\Type\Message $message
 * @property null|\Telegram\API\Type\Message $editedMessage
 * @property null|\Telegram\API\Type\Message $channelPost
 * @property null|\Telegram\API\Type\Message $editedChannelPost
 * @property null|\Telegram\API\InlineQuery\Type\InlineQuery $inlineQuery
 * @property null|\Telegram\API\InlineQuery\Type\ChosenInlineResult $chosenInlineResult
 * @property null|\Telegram\API\Type\CallbackQuery $callbackQuery
 * @property null|\Telegram\API\Payments\Type\ShippingQuery $shippingQuery
 * @property null|\Telegram\API\Payments\Type\PreCheckoutQuery $preCheckoutQuery
 * @property null|\Telegram\API\Type\Poll $poll
 * @property null|\Telegram\API\Type\PollAnswer $pollAnswer
 */
class Update extends ABaseObject {

    /**
     * This update type
     * @var null|string
     */
    private $_type = NULL;

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'id';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'id'                    => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],       'optional' => FALSE,    'external' => 'update_id'],
            'message'               => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'message',                'class' => Message::class],
            'editedMessage'         => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'edited_message',         'class' => Message::class],
            'channelPost'           => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'channel_post',           'class' => Message::class],
            'editedChannelPost'     => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'edited_channel_post',    'class' => Message::class],
            'inlineQuery'           => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'inline_query',           'class' => InlineQuery::class],
            'chosenInlineResult'    => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'chosen_inline_result',   'class' => ChosenInlineResult::class],
            'callbackQuery'         => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'callback_query',         'class' => CallbackQuery::class],
            'shippingQuery'         => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'shipping_query',         'class' => ShippingQuery::class],
            'preCheckoutQuery'      => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'pre_checkout_query',     'class' => PreCheckoutQuery::class],
            'poll'                  => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'poll',                   'class' => Poll::class],
            'pollAnswer'            => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,     'external' => 'poll_answer',            'class' => PollAnswer::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * return this updates type
     * @return string
     */
    public function getType() {
        if ($this->_type === NULL) {
            foreach (array_keys($this->_datamodel) as $field) {
                if ($field === 'id') {
                    continue;
                }
                if (isset($this->{$field})) {
                    $this->_type = $field;
                }
            }
            if ($this->_type === NULL) {
                //no new updates
                $this->_type = FALSE;
            }
        }
        return $this->_type;
    }

}
