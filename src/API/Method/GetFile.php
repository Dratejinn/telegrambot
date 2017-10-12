<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class GetFile
 * @package Telegram\API\Method
 * @property string $fileId
 */
class GetFile extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'fileId'            => ['type' => ABaseObject::T_STRING,   'optional' => FALSE, 'external' => 'file_id'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('getFile', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                if (!empty($reply->result)) {
                    return new Type\File($reply->result);
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
