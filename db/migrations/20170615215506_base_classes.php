<?php

use Telegram\db\Phinx\TelegramMigration;

use Telegram\API\Type;
use Telegram\API\Games\Type as GameType;
use Telegram\API\InlineQuery\Type as InlineQueryType;

class BaseClasses extends TelegramMigration {
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change() {
        $classes = [
            new Type\Audio,
            new Type\CallbackQuery,
            new Type\Chat,
            new Type\ChatMember,
            new Type\Contact,
            new Type\Document,
            new Type\File,
            new Type\ForceReply,
            new Type\InlineKeyboardButton,
            new Type\InlineKeyboardMarkup,
            new Type\KeyboardButton,
            new Type\Location,
            new Type\Message,
            new Type\MessageEntity,
            new Type\PhotoSize,
            new Type\ReplyKeyboardMarkup,
            new Type\ReplyKeyboardRemove,
            new \Telegram\API\Stickers\Type\Sticker,
            new Type\Update,
            new Type\User,
            new Type\UserProfilePhotos,
            new Type\Venue,
            new Type\Video,
            new Type\Voice,
            new Type\WebhookInfo,
            // new GameType\CallbackGame,
            new GameType\Game,
            new GameType\GameHighScore,
            new InlineQueryType\ChosenInlineResult,
            new InlineQueryType\InlineQuery,
            new InlineQueryType\InlineQueryResultArticle,
            new InlineQueryType\InlineQueryResultAudio,
            new InlineQueryType\InlineQueryResultCachedAudio,
            new InlineQueryType\InlineQueryResultCachedDocument,
            new InlineQueryType\InlineQueryResultCachedGif,
            new InlineQueryType\InlineQueryResultCachedMpeg4Gif,
            new InlineQueryType\InlineQueryResultCachedPhoto,
            new InlineQueryType\InlineQueryResultCachedSticker,
            new InlineQueryType\InlineQueryResultCachedVideo,
            new InlineQueryType\InlineQueryResultCachedVoice,
            new InlineQueryType\InlineQueryResultContact,
            new InlineQueryType\InlineQueryResultDocument,
            new InlineQueryType\InlineQueryResultGif,
            new InlineQueryType\InlineQueryResultLocation,
            new InlineQueryType\InlineQueryResultMpeg4Gif,
            new InlineQueryType\InlineQueryResultPhoto,
            new InlineQueryType\InlineQueryResultVenue,
            new InlineQueryType\InlineQueryResultVideo,
            new InlineQueryType\InlineQueryResultVoice
        ];
        foreach ($classes as $class) {
            $this->_migrateTelegramClass($class);
        }
    }
}
