<?php

declare(strict_types = 1);

namespace Telegram\LogHelpers\Interfaces;

use Psr\Log;

/**
 * Describes a logger-aware instance.
 */
interface ILoggerAwareInterface extends Log\LoggerAwareInterface {
    public function hasLogger() : bool;
    public function getLogger() : Log\LoggerInterface;
}
