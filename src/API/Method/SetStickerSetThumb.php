<?php

declare(strict_types=1);

namespace Telegram\API\Method;

use Telegram\API\Base\InputFile;
use Telegram\API\Type;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class GetFile
 * @package Telegram\API\Method
 * @property string $name
 * @property int|float $userId
 * @property null|string|\Telegram\API\Base\InputFile $thumb
 */
class SetStickerSetThumb extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'name' => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'name'],
            'userId' => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT], 'optional' => FALSE, 'external' => 'user_id'],
            'thumb' => ['type' => [ABaseObject::T_OBJECT, ABaseObject::T_STRING], 'optional' => TRUE, 'external' => 'thumb', 'class' => InputFile::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('setStickerSetThumb', $this);
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
