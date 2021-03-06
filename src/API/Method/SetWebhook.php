<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\API\Base\InputFile;

/**
 * Class SetWebhook
 * @package Telegram\API\Method
 * @property string $url
 * @property null|\Telegram\API\Base\InputFile $certificate
 * @property null|string $ipAddress
 * @property null|int $maxConnections
 * @property null|string[] $allowedUpdates
 * @property null|bool $dropPendingUpdates
 */
class SetWebhook extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'url'                   => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'url'],
            'certificate'           => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'certificate',    'class' => InputFile::class],
            'ipAddress'             => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'ip_address'],
            'maxConnections'        => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'max_connections'],
            'allowedUpdates'        => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'allowed_updates'],
            'dropPendingUpdates'    => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'drop_pending_updates']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('setWebhook', $this);
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
