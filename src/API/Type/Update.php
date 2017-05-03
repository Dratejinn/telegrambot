<?php

declare(strict_types=1);

namespace Telegram\API\Type;
use Telegram\API\InlineQuery\{ChosenInlineResult, InlineQuery};

use Telegram\API\Base\Abstracts\ABaseObject;

class Update extends ABaseObject {

    private $_type = NULL;

    public static function GetDatamodel() : array {
        $datamodel = [
            'id'                    => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'update_id'],
            'message'               => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'message',                'class' => Message::class],
            'editedMessage'         => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'edited_message',         'class' => Message::class],
            'channelPost'           => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'channel_post',           'class' => Message::class],
            'editedChannelPost'     => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'edited_channel_post',    'class' => Message::class],
            'inlineQuery'           => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'inline_query',           'class' => InlineQuery::class],
            'chosenInlineResult'    => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'chosen_inline_result',   'class' => ChosenInlineResult::class],
            'callbackQuery'         => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'callback_query',         'class' => CallbackQuery::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

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
