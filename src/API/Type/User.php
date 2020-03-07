<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class User
 * @package Telegram\API\Type
 * @property int $id
 * @property bool $isBot
 * @property string $firstName
 * @property null|string $lastName
 * @property null|string $username
 * @property null|string $languageCode
 * @property null|bool $canJoinGroups
 * @property null|bool $canReadAllGroupMessages
 * @property null|bool $supportsInlineQueries
 */
class User extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'id';

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $dataModel = [
            'id'                        => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'id'],
            'isBot'                     => ['type' => ABaseObject::T_BOOL,      'optional' => FALSE,    'external' => 'is_bot'],
            'firstName'                 => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'first_name'],
            'lastName'                  => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'last_name'],
            'username'                  => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'username'],
            'languageCode'              => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'language_code'],
            'canJoinGroups'             => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_join_groups'],
            'canReadAllGroupMessages'   => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'can_read_all_group_messages'],
            'supportsInlineQueries'     => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'supports_inline_queries']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }

    /**
     * Get this users fullname; if lastname is not available returns the firstname
     * @return string
     */
    public function getFullName() : string {
        $name = $this->firstName;
        if (isset($this->lastName)) {
            $name .=  ' ' . $this->lastName;
        }
        return $name;
    }

    /**
     * returns the username if available
     * @return string
     */
    public function getUsername() : string {
        return $this->username ?? '';
    }
}
