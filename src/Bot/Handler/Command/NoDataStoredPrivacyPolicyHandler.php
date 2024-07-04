<?php

declare(strict_types = 1);

namespace Telegram\Bot\Handler\Command;

class NoDataStoredPrivacyPolicyHandler extends AMarkdownPrivacyHandler {

    protected function _getMarkdownContentPath() : string {
        return __DIR__ . '/NoDataStoredPolicy.md';
    }
}
