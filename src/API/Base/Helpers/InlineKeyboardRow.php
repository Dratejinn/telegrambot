<?php

declare(strict_types = 1);

namespace Telegram\API\Base\Helpers;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Type\InlineKeyboardButton;

class InlineKeyboardRow extends ABaseObject {
    public static function GetDatamodel() : array {
        $datamodel = [
            'buttons' => ['type' => ABaseObject::T_ARRAY, 'optional' => FALSE, 'external' => 'buttons'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function addButton(InlineKeyboardButton $button) {
        $buttons = $this->buttons;
        $buttons[] = $button;
        $this->buttons = $buttons;
    }

    public function jsonify() {
        return $this->buttons;
    }
}