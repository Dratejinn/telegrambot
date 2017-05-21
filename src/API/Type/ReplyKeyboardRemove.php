<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class ReplyKeyboardRemove extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
        'removeKeyboard'    => ['type' => ABaseObject::T_BOOL,      'optional' => FALSE,   'external' => 'remove_keyboard'],
        'selective'         => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,    'external' => 'selective'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        $this->removeKeyboard = TRUE;
    }

    public function __set(string $name, $value) {
        $sName = lcfirst($name);
        if ($sName === 'removeKeyboard') {
            return;
        }
        parent::__set($name, $value);
    }
}
