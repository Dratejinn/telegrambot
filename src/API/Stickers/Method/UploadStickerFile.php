<?php

declare(strict_types=1);


namespace Telegram\API\Stickers\Method;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Base\InputFile;
use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Bot;
use Telegram\API\Type\File;

/**
 * Class UploadStickerFile
 * @package Telegram\API\Stickers\Method
 * @property int $userId
 * @property \Telegram\API\Base\InputFile $pngSticker
 */
class UploadStickerFile extends ABaseObject implements IOutbound {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel(): array {
        $datamodel = [
            'userId'        => ['type' => ABaseObject::T_INT,    'optional' => FALSE, 'external' => 'user_id'],
            'pngSticker'    => ['type' => ABaseObject::T_OBJECT, 'optional' => FALSE, 'external' => 'png_sticker', 'class' => InputFile::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * @inheritdoc
     */
    public function call(Bot $bot) {
        $reply = $bot->call('uploadStickerFile', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                return new File($reply->result);
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
