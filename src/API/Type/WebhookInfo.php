<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class WebhookInfo
 * @package Telegram\API\Type
 * @property string $url
 * @property bool $hasCustomCertificate
 * @property int $pendingUpdateCount
 * @property null|string $ipAddress
 * @property null|int $lastErrorDate
 * @property null|string $lastErrorMessage
 * @property null|int $maxConnections
 * @property null|string[] $allowedUpdates
 */
class WebhookInfo extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'url'                       => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'url'],
            'hasCustomCertificate'      => ['type' => ABaseObject::T_BOOL,      'optional' => FALSE,    'external' => 'has_custom_certificate'],
            'pendingUpdateCount'        => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'pending_update_count'],
            'ipAddress'                 => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'ip_address'],
            'lastErrorDate'             => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'last_error_date'],
            'lastErrorMessage'          => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'last_error_message'],
            'maxConnections'            => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'max_connections'],
            'allowedUpdates'            => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'allowed_updates']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
