<?php

declare(strict_types = 1);


namespace Telegram\API\Passport;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

class SetPassportDataErrors extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $dataModel = [
            'userId' => ['type' => [ABaseObject::T_INT, ABaseObject::T_FLOAT], 'optional' => FALSE, 'external' => 'user_id'],
            'errors' => ['type' => ABaseObject::T_ARRAY, 'optional' => FALSE, 'external' => 'errors']
        ];
        return array_merge(parent::GetDatamodel(), $dataModel);
    }


    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('setPassportDataErrors', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return TRUE;
            } else {
                if (isset($reply->description)) {
                    throw new \Exception("Could not properly execute the request!\n" . $reply->description);
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
    }
}
