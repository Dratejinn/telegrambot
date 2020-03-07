<?php

declare(strict_types = 1);

namespace Telegram\API\Passport\Error;

use Telegram\API\Passport\AFileHashPassportError;

class PassportElementErrorReverseSide extends AFileHashPassportError {

    const T_DRIVER_LICENSE = 'driver_license';
    const T_IDENTITY_CARD = 'identity_card';

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        $this->source = 'reverse_side';
    }

}
