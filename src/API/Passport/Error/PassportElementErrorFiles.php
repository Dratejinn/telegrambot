<?php

declare(strict_types = 1);

namespace Telegram\API\Passport\Error;

use Telegram\API\Passport\AMultipleFileHashPassportError;

class PassportElementErrorFiles extends AMultipleFileHashPassportError {

    const T_UTILITY_BILL = 'utility_bill';
    const T_BANK_STATEMENT = 'bank_statement';
    const T_RENTAL_AGREEMENT = 'rental_agreement';
    const T_PASSPORT_REGISTRATION = 'passport_registration';
    const T_TEMPORARY_REGISTRATION = 'temporary_registration';

    public function __construct(\stdClass $payload = NULL) {
        parent::__construct($payload);

        $this->source = 'files';
    }


}
