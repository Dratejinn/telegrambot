<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class ReplyKeyboardMarkup
 * @package Telegram\API\Type
 * @property array $keyboard
 * @property null|bool $resizeKeyboard
 * @property null|bool $oneTimeKeyboard
 * @property null|bool $selective
 */
class ReplyKeyboardMarkup extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'keyboard'          => ['type' => ABaseObject::T_ARRAY,  'optional' => FALSE,    'external' => 'keyboard'],
            'resizeKeyboard'    => ['type' => ABaseObject::T_BOOL,   'optional' => TRUE,     'external' => 'resize_keyboard'],
            'oneTimeKeyboard'   => ['type' => ABaseObject::T_BOOL,   'optional' => TRUE,     'external' => 'one_time_keyboard'],
            'selective'         => ['type' => ABaseObject::T_BOOL,   'optional' => TRUE,     'external' => 'selective'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * ReplyKeyboardMarkup constructor.
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        if (isset($this->keyboard)) {
            $keyboard = [];
            foreach ($this->keyboard as $keyboardArray) {
                $buttonRow = [];
                foreach ($keyboardArray as $inlineKeyboardButton) {
                    $buttonRow[] = new KeyboardButton($inlineKeyboardButton);
                }
                $keyboard[] = $buttonRow;
            }
            $this->keyboard = $keyboard;
        }
    }
}
