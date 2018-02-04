<?php

declare(strict_types = 1);

namespace Telegram\API\Type;

use Telegram\API\Base\Abstracts\AInputMedia;

class InputMediaPhoto extends AInputMedia {

    /**
     * InputMediaPhoto constructor.
     * @param \stdClass|NULL $payload
     */
    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);
        $this->type = 'photo';
    }
}
