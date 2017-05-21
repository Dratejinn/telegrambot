<?php

declare(strict_types=1);

namespace Telegram\API\Games\Method;

use Telegram\API\Base\Interfaces\IOutbound;
use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\API\Type\GameHighScore;

class GetGameHighScores extends ABaseObject implements IOutbound {

    public static function GetDatamodel() : array {
        $datamodel = [
            'userId'            => ['type' => ABaseObject::T_INT,       'optional' => FALSE, 'external' => 'user_id'],
            'chatId'            => ['type' => ABaseObject::T_INT,       'optional' => TRUE,  'external' => 'chat_id'],
            'messageId'         => ['type' => ABaseObject::T_INT,       'optional' => TRUE,  'external' => 'message_id'],
            'inlineMessageid'   => ['type' => ABaseObject::T_STRING,    'optional' => TRUE,  'external' => 'inline_message_id'],
        ];
        return array_merge(parent::GetDatamodel(), $datamodel);
    }

    public function call(Bot $bot) {
        $reply = $bot->call('getGameHighScores', $this);
        if ($reply instanceof \stdClass) {
            if ($reply->ok) {
                $gameHighScores = [];
                foreach ($reply->result as $highscore) {
                    $gameHighScores[] = new GameHighScore($highscore);
                }
                return $gameHighScores;
            } else {
                if (isset($reply->description)) {
                    echo "Could not properly execute the request!\n\n" . $reply->description . PHP_EOL;
                } else {
                    throw new \Exception('An unknown error has occurred!');
                }
            }
        }
    }
}
