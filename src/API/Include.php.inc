<?php

declare(strict_types = 1);

namespace TelegramBot\API;

/* Base */
require_once __DIR__ . '/Base/Interface/IOutbound.php.inc';
require_once __DIR__ . '/Base/Abstract/ABaseObject.php.inc';
require_once __DIR__ . '/Base/Abstract/ASend.php.inc';

/* Type */
require_once __DIR__ . '/Type/Audio.php.inc';
require_once __DIR__ . '/Type/CallbackQuery.php.inc';
require_once __DIR__ . '/Type/Chat.php.inc';
require_once __DIR__ . '/Type/ChatMember.php.inc';
require_once __DIR__ . '/Type/Contact.php.inc';
require_once __DIR__ . '/Type/Document.php.inc';
require_once __DIR__ . '/Type/ForceReply.php.inc';
require_once __DIR__ . '/Type/InlineKeyboard.php.inc';
require_once __DIR__ . '/Type/InlineKeyboardButton.php.inc';
require_once __DIR__ . '/Type/KeyboardButton.php.inc';
require_once __DIR__ . '/Type/Location.php.inc';
require_once __DIR__ . '/Type/Message.php.inc';
require_once __DIR__ . '/Type/MessageEntity.php.inc';
require_once __DIR__ . '/Type/PhotoSize.php.inc';
require_once __DIR__ . '/Type/ReplyKeyboardMarkup.php.inc';
require_once __DIR__ . '/Type/ReplyKeyboardRemove.php.inc';
require_once __DIR__ . '/Type/Sticker.php.inc';
require_once __DIR__ . '/Type/Update.php.inc';
require_once __DIR__ . '/Type/User.php.inc';
require_once __DIR__ . '/Type/UserProfilePhotos.php.inc';
require_once __DIR__ . '/Type/Venue.php.inc';
require_once __DIR__ . '/Type/Video.php.inc';
require_once __DIR__ . '/Type/Voice.php.inc';

/* Method */
require_once __DIR__ . '/Method/GetMe.php.inc';
require_once __DIR__ . '/Method/SendMessage.php.inc';
require_once __DIR__ . '/Method/GetUpdates.php.inc';
require_once __DIR__ . '/Method/AnswerCallbackQuery.php.inc';
require_once __DIR__ . '/Method/EditMessageReplyMarkup.php.inc';
require_once __DIR__ . '/Method/GetChatMember.php.inc';
require_once __DIR__ . '/Method/SendAudio.php.inc';
require_once __DIR__ . '/Method/SendDocument.php.inc';
require_once __DIR__ . '/Method/SendPhoto.php.inc';
require_once __DIR__ . '/Method/SendVideo.php.inc';

/* Root */
require_once __DIR__ . '/API.php.inc';
require_once __DIR__ . '/Bot.php.inc';
require_once __DIR__ . '/ConfigManager.php.inc';
