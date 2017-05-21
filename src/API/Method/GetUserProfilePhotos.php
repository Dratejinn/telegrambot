<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

class GetUserProfilePhotos extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $datamodel = [
            'userId'            => ['type' => ABaseObject::T_INT,   'optional' => FALSE, 'external' => 'user_id'],
            'limit'             => ['type' => ABaseObject::T_INT,   'optional' => TRUE,  'external' => 'limit'],
            'offset'            => ['type' => ABaseObject::T_INT,   'optional' => TRUE,  'external' => 'timeout'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function call(Bot $bot) {
        $reply = $bot->call('getUserProfilePhotos', $this);
        $arr = [];
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if (!empty($reply->result)) {
                    return new Type\UserProfilePhotos($reply->result);
                }
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
