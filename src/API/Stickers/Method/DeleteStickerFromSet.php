<?php

declare(strict_types=1);


namespace Telegram\API\Stickers\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;

/**
 * Class DeleteStickerFromSet
 * @package Telegram\API\Stickers\Method
 * @property string $sticker
 */
class DeleteStickerFromSet extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'sticker'   => ['type' => ABaseObject::T_STRING, 'optional' => FALSE, 'external' => 'sticker']
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('deleteStickerFromSet', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return new $reply->result;
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
