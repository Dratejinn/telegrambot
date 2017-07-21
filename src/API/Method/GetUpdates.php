<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class GetUpdates
 * @package Telegram\API\Method
 * @property null|int $offset
 * @property null|int $limit
 * @property null|int $timeout
 * @property null|string[] $allowedUpdates
 */
class GetUpdates extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'offset'            => ['type' => ABaseObject::T_FLOAT,   'optional' => TRUE, 'external' => 'offset'],
            'limit'             => ['type' => ABaseObject::T_INT,   'optional' => TRUE, 'external' => 'limit'],
            'timeout'           => ['type' => ABaseObject::T_INT,   'optional' => TRUE, 'external' => 'timeout'],
            'allowedUpdates'    => ['type' => ABaseObject::T_ARRAY, 'optional' => TRUE, 'external' => 'allowed_updates']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('getUpdates', $this);
        $arr = [];
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if (!empty($reply->result)) {
                    foreach ($reply->result as $result) {
                        $arr[] = new Type\Update($result);
                    }
                }
            } else {
                if (isset($reply->description)) {
                    throw new \Exception("Could not properly execute the request!\n" . $reply->description);
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
        return $arr;
    }
}
