<?php

declare(strict_types=1);


namespace Telegram\API\Stickers\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class SetStickerPositionInSet
 * @package Telegram\API\Stickers\Method
 * @property string $sticker
 * @property int $position
 */
class SetStickerPositionInSet extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'sticker'   => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'sticker'],
            'position'  => ['type' => ABaseObject::T_INT,    'optional' => FALSE, 'external' => 'position']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('setStickerPositionInSet', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return $reply->result;
            } else {
                if (isset($reply->description)) {
                    $bot->logAlert("Could not properly execute the request!\n\n" . $reply->description . PHP_EOL);
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
    }
}
