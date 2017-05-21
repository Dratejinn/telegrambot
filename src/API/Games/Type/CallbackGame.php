<?php

declare(strict_types=1);

namespace Telegram\API\Games\Type;

use Telegram\API\Base\Abstracts\ABaseObject;

class CallbackGame extends ABaseObject {
    public function __construct(\stdClass $payload = NULL) {
        throw new \Exception('This is a placeholder for future implementation');
    }
}
