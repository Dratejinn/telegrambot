<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

/**
 * Class ForceReply
 * @package Telegram\API\Type
 * @property bool $forceReply
 * @property null|bool $selective
 */
class ForceReply extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'forceReply'    => ['type' => ABaseObject::T_BOOL,  'optional' => FALSE,    'external' => 'force_reply'],
            'selective'     => ['type' => ABaseObject::T_BOOL,  'optional' => TRUE,     'external' => 'selective'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        $this->forceReply = TRUE;
    }

}
