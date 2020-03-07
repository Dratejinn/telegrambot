<?php

declare(strict_types=1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Games\Type\Game;
use Telegram\API\Passport\PassportData;
use Telegram\API\Payments\Type\{Invoice, SuccessfulPayment};
use Telegram\API\Stickers\Type\Sticker;

/**
 * Class Message
 * @package Telegram\API\Type
 * @property int $id
 * @property null|\Telegram\API\Type\User $from
 * @property int $date
 * @property \Telegram\API\Type\Chat $chat
 * @property null|\Telegram\API\Type\User $forwardFrom
 * @property null|int $forwardFromMessageId
 * @property null|string $forwardSignature
 * @property null|string $forwardSenderName
 * @property null|int $forwardDate
 * @property null|\Telegram\API\Type\Message $replyToMessage
 * @property null|string $authorSignature
 * @property null|int $editDate
 * @property null|string $text
 * @property null|\Telegram\API\Type\MessageEntity[] $entities
 * @property null|\Telegram\API\Type\MessageEntity[] $captionEntities
 * @property null|\Telegram\API\Type\Audio $audio
 * @property null|\Telegram\API\Type\Document $document
 * @property null|\Telegram\API\Games\Type\Game $game
 * @property null|\Telegram\API\Type\PhotoSize[] $photo
 * @property null|\Telegram\API\Stickers\Type\Sticker $sticker
 * @property null|\Telegram\API\Type\Video $video
 * @property null|\Telegram\API\Type\VideoNote $videoNote
 * @property null|string $caption
 * @property null|\Telegram\API\Type\Contact $contact
 * @property null|\Telegram\API\Type\Location $location
 * @property null|\Telegram\API\Type\Venue $venue
 * @property null|\Telegram\API\Type\Poll $poll
 * @property null|\Telegram\API\Type\User $newChatMember
 * @property null|\Telegram\API\Type\User[] $newChatMembers
 * @property null|\Telegram\API\Type\User $leftChatMember
 * @property null|string $newChatTitle
 * @property null|\Telegram\API\Type\PhotoSize[] $newChatPhoto
 * @property null|bool $deleteChatPhoto
 * @property null|bool $groupChatCreated
 * @property null|bool $superGroupChatCreated
 * @property null|bool $channelChatCreated
 * @property null|int|float $migrateToChatId
 * @property null|int|float $migrateFromChatId
 * @property null|\Telegram\API\Type\Message $pinnedMessage
 * @property null|\Telegram\API\Payments\Type\Invoice $invoice
 * @property null|\Telegram\API\Payments\Type\SuccessfulPayment $succesfulPayment
 * @property null|string $connectedWebsite
 * @property null|\Telegram\API\Passport\PassportData $passportData
 * @property null|\Telegram\API\Type\InlineKeyboardMarkup $replyMarkup
 */
class Message extends ABaseObject {

    /**
     * @inheritdoc
     */
    protected static $_IdProp = 'id';

    /**
     * @var null|string
     */
    private $_type = NULL;

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        $datamodel = [
            'id'                    => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'message_id'],
            'from'                  => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'from',                       'class' => User::class],
            'date'                  => ['type' => ABaseObject::T_INT,       'optional' => FALSE,    'external' => 'date'],
            'chat'                  => ['type' => ABaseObject::T_OBJECT,    'optional' => FALSE,    'external' => 'chat',                       'class' => Chat::class],
            'forwardFrom'           => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'forward_from',               'class' => User::class],
            'forwardFromMessageId'  => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'forward_from_message_id'],
            'forwardSignature'      => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'forward_signature'],
            'forwardSenderName'     => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'forward_sender_name'],
            'forwardDate'           => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'forward_date'],
            'replyToMessage'        => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'reply_to_message',           'class' => Message::class],
            'authorSignature'       => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'author_signature'],
            'editDate'              => ['type' => ABaseObject::T_INT,       'optional' => TRUE,     'external' => 'edit_date'],
            'text'                  => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'text'],

            'entities'              => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'entities'],
            'captionEntities'       => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'caption_entities'],
            'audio'                 => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'audio',                      'class' => Audio::class],
            'document'              => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'document',                   'class' => Document::class],
            'animation'             => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'animation',                  'class' => Animation::class],
            'game'                  => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'game',                       'class' => Game::class],
            'photo'                 => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'photo'],
            'sticker'               => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'sticker',                    'class' => Sticker::class],
            'video'                 => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'video',                      'class' => Video::class],
            'voice'                 => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'voice',                      'class' => Voice::class],
            'videoNote'             => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'video_note',                 'class' => VideoNote::class],
            'caption'               => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'caption'],
            'contact'               => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'contact',                    'class' => Contact::class],
            'location'              => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'location',                   'class' => Location::class],
            'venue'                 => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'venue',                      'class' => Venue::class],
            'poll'                  => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'poll',                       'class' => Poll::class],

            'newChatMembers'        => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'new_chat_members'],
            'leftChatMember'        => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'left_chat_member',           'class' => User::class],
            'newChatTitle'          => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'new_chat_title'],
            'newChatPhoto'          => ['type' => ABaseObject::T_ARRAY,     'optional' => TRUE,     'external' => 'new_chat_photo'],
            'deleteChatPhoto'       => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'delete_chat_photo'],
            'groupChatCreated'      => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'group_chat_created'],
            'superGroupChatCreated' => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'supergroup_chat_created'],
            'channelChatCreated'    => ['type' => ABaseObject::T_BOOL,      'optional' => TRUE,     'external' => 'channel_chat_created'],
            'migrateToChatId'       => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],       'optional' => TRUE,     'external' => 'migrate_to_chat_id'],
            'migrateFromChatId'     => ['type' => [ABaseObject::T_FLOAT, ABaseObject::T_INT],       'optional' => TRUE,     'external' => 'migrateFromChatId'],
            'pinnedMessage'         => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'pinned_message',             'class' => Message::class],
            'invoice'               => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'invoice',                    'class' => Invoice::class],
            'successfulPayment'     => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'successful_payment',         'class' => SuccessfulPayment::class],
            'connectedWebsite'      => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,     'external' => 'connected_website'],
            'passportData'          => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'passport_data',              'class' => PassportData::class],
            'replyMarkup'           => ['type' => ABaseObject::T_OBJECT,    'optional' => TRUE,     'external' => 'reply_markup',               'class' => InlineKeyboardMarkup::class]
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    /**
     * Message constructor.
     * @inheritdoc
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        if (isset($this->entities)) {
            $entities = [];
            foreach ($this->entities as $entity) {
                $entities[] = new MessageEntity($entity);
            }
            $this->entities = $entities;
        }

        if (isset($this->captionEntities)) {
            $entities = [];
            foreach ($this->captionEntities as $entity) {
                $entities[] = new MessageEntity($entity);
            }
            $this->captionEntities = $entities;
        }

        if (isset($this->photo)) {
            $photoSizes = [];
            foreach ($this->photo as $photoSize) {
                $photoSizes[] = new PhotoSize($photoSize);
            }
            $this->photo = $photoSizes;
        }

        if (isset($this->newChatPhoto)) {
            $photoSizes = [];
            foreach ($this->newChatPhoto as $photoSize) {
                $photoSizes[] = new PhotoSize($photoSize);
            }
            $this->newChatPhoto = $photoSizes;
        }
        if (isset($this->newChatMembers)) {
            $chatMembers = [];
            foreach ($this->newChatMembers as $chatMember) {
                $chatMembers[] = new User($chatMember);
            }
            $this->newChatMembers = $chatMembers;
        }
    }

    /**
     * Returns the content type of this message
     * @return string
     */
    public function getContentType() : string {
        if ($this->_type === NULL) {
            foreach (array_keys($this->_datamodel) as $field) {
                if ($field === 'id') {
                    continue;
                }
                if (isset($this->{$field})) {
                    $this->_type = $field;
                }
            }
        }
        return $this->_type;
    }

}
