<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\InputFile;
use Telegram\API\Base\Interfaces\IOutbound;

class SetChatTitle extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $datamodel = [
            'chatId'    => ['type' => [ABaseObject::T_STRING, ABaseObject::T_INT], 'optional' => FALSE, 'external' => 'chat_id'],
            'title'     => ['type' => ABaseObject::T_STRING,                      'optional' => FALSE, 'external' => 'title']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function call(Bot $bot) {
        $reply = $bot->call('setChatTitle', $this);
        $arr = [];
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if (!empty($reply->result)) {
                    return $reply->result;
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
