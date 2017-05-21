<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class WebhookInfo extends ABaseObject {

    public static function GetDatamodel() : array {
        $datamodel = [
            'url'                       => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'url'],
            'hasCustomCertificate'      => ['type' => ABaseObject::T_BOOL,      'optional' => FALSE,    'external' => 'has_custom_certificate'],
            'pendingUpdateCount'        => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'pending_update_count'],
            'lastErrorDate'             => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'last_error_date'],
            'lastErrorMessage'          => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'last_error_message'],
            'pendingUpdateCount'        => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'pending_update_count'],
            'allowedUpdates'            => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'allowed_updates']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }
}
