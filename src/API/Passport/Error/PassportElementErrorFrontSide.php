<?php

declare(strict_types = 1);

namespace Telegram\API\Passport\Error;

use Telegram\API\Passport\AFileHashPassportError;

class PassportElementErrorFrontSide extends AFileHashPassportError {

    const T_PASSPORT = 'passport';
    const T_DRIVER_LICENSE = 'driver_license';
    const T_IDENTITY_CARD = 'identity_card';
    const T_INTERNAL_PASSPORT = 'internal_passport';

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        $this->source = 'front_side';
    }

}
