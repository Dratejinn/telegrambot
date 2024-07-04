<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\Exception\OutboundException;

/**
 * Class GetUserProfilePhotos
 * @package Telegram\API\Method
 * @property int $userId
 * @property null|int $limit
 * @property null|int $offset
 */
class GetUserProfilePhotos extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'userId'            => ['type' => ABaseObject::T_INT,   'optional' => FALSE, 'external' => 'user_id'],
            'limit'             => ['type' => ABaseObject::T_INT,   'optional' => TRUE,  'external' => 'limit'],
            'offset'            => ['type' => ABaseObject::T_INT,   'optional' => TRUE,  'external' => 'timeout'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('getUserProfilePhotos', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if (!empty($reply->result)) {
                    return new Type\UserProfilePhotos($reply->result);
                }
            } elseif (isset($reply->description)) {
                throw new OutboundException($this, $reply, "Could not properly execute the request!\n" . $reply->description);
            }
        }
        throw new OutboundException($this, $reply, 'An unknown error has occurred!');
    }
}
