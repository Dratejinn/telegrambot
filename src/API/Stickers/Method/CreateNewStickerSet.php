<?php

declare(strict_types=1);


namespace Telegram\API\Stickers\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\InputFile;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\API\Stickers\Type\MaskPosition;

/**
 * Class CreateNewStickerSet
 * @package Telegram\API\Stickers\Method
 * @property int $userId
 * @property string $name
 * @property string $title
 * @property null|string|\Telegram\API\Base\InputFile $pngSticker
 * @property null|string|\Telegram\API\Base\InputFile $tgsSticker
 * @property string $emojis
 * @property null|bool $isMasks
 * @property null|\Telegram\API\Stickers\Type\MaskPosition $maskPosition
 */
class CreateNewStickerSet extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'userId'        => ['type' => ABaseObject::T_INT,                               'optional' => FALSE, 'external' => 'user_id'],
            'name'          => ['type' => ABaseObject::T_STRING,                            'optional' => FALSE, 'external' => 'name'],
            'title'         => ['type' => ABaseObject::T_STRING,                            'optional' => FALSE, 'external' => 'title'],
            'pngSticker'    => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => TRUE,  'external' => 'png_sticker',       'class' => InputFile::class],
            'tgsSticker'    => ['type' => [ABaseObject::T_STRING, ABaseObject::T_OBJECT],   'optional' => TRUE,  'external' => 'tgs_sticker',       'class' => InputFile::class],
            'emojis'        => ['type' => ABaseObject::T_STRING,                            'optional' => FALSE, 'external' => 'emojis'],
            'isMasks'       => ['type' => ABaseObject::T_BOOL,                              'optional' => TRUE,  'external' => 'is_masks'],
            'maskPosition'  => ['type' => ABaseObject::T_OBJECT,                            'optional' => TRUE,  'external' => 'mask_position',     'class' => MaskPosition::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('createNewStickerSet', $this);
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
