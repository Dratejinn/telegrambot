<?php

declare(strict_types = 1);

namespace Telegram\LogHelpers\Interfaces;

use Psr\Log;

/**
 * Describes a logger-aware instance.
 */
interface ILoggerAwareInterface {
    /**
     * Used to check whether the implementing class has a logger
     * @return bool
     */
    public function hasLogger() : bool;

    /**
     * Used to get the logger from the implementing class
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger() : Log\LoggerInterface;

    /**
     * Used to set the logger for the implementing class
     * @param \Psr\Log\LoggerInterface $logger
     * @return null
     */
    public function setLogger(Log\LoggerInterface $logger);
}
