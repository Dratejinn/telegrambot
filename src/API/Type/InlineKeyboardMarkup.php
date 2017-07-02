<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class InlineKeyboardMarkup extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'inlineKeyboard' => ['type' => ABaseObject::T_ARRAY, 'optional' => FALSE, 'external' => 'inline_keyboard'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        if (isset($this->inlineKeyboard)) {
            $keyboard = [];
            foreach ($this->inlineKeyboard as $keyboardArray) {
                $buttonRow = [];
                foreach ($keyboardArray as $inlineKeyboardButton) {
                    $buttonRow[] = new InlineKeyboardButton($inlineKeyboardButton);
                }
                $keyboard[] = $buttonRow;
            }
            $this->inlineKeyboard = $keyboard;
        }
    }
    public function addRow(array $row) {
        foreach ($row as $rowButton) {
            if (!$rowButton instanceof InlineKeyboardButton) {
                throw new \Exception('Entry of row is not an instance of InlineKeyboardButton');
            }
        }
        $this->inlineKeyboard[] = $row;
    }
}
