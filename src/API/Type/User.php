<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class User extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'id'            => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'id'],
            'firstName'     => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'first_name'],
            'lastName'      => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'last_name'],
            'username'      => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'username'],
            'languageCode' => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'language_code']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function getFullName() : string {
        $name = $this->firstName;
        if (isset($this->lastName)) {
            $name .=  ' ' . $this->lastName;
        }
        return $name;
    }

    public function getUsername() : string {
        return $this->username;
    }
}
