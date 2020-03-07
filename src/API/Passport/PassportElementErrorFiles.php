<?php

declare(strict_types = 1);

namespace Telegram\API\Passport;

class PassportElementErrorFiles extends AMultipleFileHashPassportError {

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        $this->source = 'files';
    }


}
