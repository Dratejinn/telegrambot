<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class VoiceChatParticipantsInvited
 * @package Telegram\API\Type
 * @property null|\Telegram\API\Type\User[] $users
 */
class VoiceChatParticipantsInvited extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'users' => ['type' => ABaseObject::T_ARRAY, 'optional' => TRUE, 'external' => 'users']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        if (isset($this->users)) {
            $users = [];
            foreach ($this->users as $user) {
                $users[] = new User($user);
            }
            $this->users = $users;
        }
    }


}
