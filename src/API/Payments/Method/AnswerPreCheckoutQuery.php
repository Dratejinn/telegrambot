<?php

declare(strict_types=1);

namespace Telegram\API\Payments\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class AnswerPreCheckoutQuery
 * @package Telegram\API\Payments\Method
 * @property string $preCheckoutQueryId
 * @property bool $ok
 * @property null|string $errorMessage
 */
class AnswerPreCheckoutQuery extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'preCheckoutQueryId' => ['type' => ABaseObject::T_STRING,    'optional' => FALSE,    'external' => 'pre_checkout_query_id'],
            'ok'                 => ['type' => ABaseObject::T_BOOL,      'optional' => FALSE,    'external' => 'ok'],
            'errorMessage'       => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'error_message'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('answerPreCheckoutQuery', $this);
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
