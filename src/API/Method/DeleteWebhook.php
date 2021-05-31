<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class DeleteWebhook
 * @package Telegram\API\Method
 * @property null|bool $dropPendingUpdates
 */
class DeleteWebhook extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $datamodel = [
            'dropPendingUpdates' => ['type' => ABaseObject::T_BOOL, 'optional' => TRUE, 'external' => 'drop_pending_updates']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }


    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('deleteWebhook', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return TRUE;
            }
        }
        return NULL;
    }
}
