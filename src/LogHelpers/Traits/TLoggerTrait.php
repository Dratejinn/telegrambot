<?php

declare(strict_types = 1);

namespace Telegram\LogHelpers\Traits;

use Psr\Log;

trait TLoggerTrait
{

    private $_logger = NULL;

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logEmergency($message, array $context = array()) {
        if (empty($context) && method_exists($this, 'getLoggerContext')) {
            $context = $this->getLoggerContext();
        }
        if ($this->hasLogger()) {
            $this->getLogger()->emergency($message, $context);
        }
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logAlert($message, array $context = array()) {
        if (empty($context) && method_exists($this, 'getLoggerContext')) {
            $context = $this->getLoggerContext();
        }
        if ($this->hasLogger()) {
            $this->getLogger()->alert($message, $context);
        }
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logCritical($message, array $context = array()) {
        if (empty($context) && method_exists($this, 'getLoggerContext')) {
            $context = $this->getLoggerContext();
        }
        if ($this->hasLogger()) {
            $this->getLogger()->critical($message, $context);
        }
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logError($message, array $context = array()) {
        if (empty($context) && method_exists($this, 'getLoggerContext')) {
            $context = $this->getLoggerContext();
        }
        if ($this->hasLogger()) {
            $this->getLogger()->error($message, $context);
        }
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logWarning($message, array $context = array()) {
        if (empty($context) && method_exists($this, 'getLoggerContext')) {
            $context = $this->getLoggerContext();
        }
        if ($this->hasLogger()) {
            $this->getLogger()->warning($message, $context);
        }
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logNotice($message, array $context = array()) {
        if (empty($context) && method_exists($this, 'getLoggerContext')) {
            $context = $this->getLoggerContext();
        }
        if ($this->hasLogger()) {
            $this->getLogger()->notice($message, $context);
        }
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logInfo($message, array $context = array()) {
        if (empty($context) && method_exists($this, 'getLoggerContext')) {
            $context = $this->getLoggerContext();
        }
        if ($this->hasLogger()) {
            $this->getLogger()->info($message, $context);
        }
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logDebug($message, array $context = array()) {
        if (empty($context) && method_exists($this, 'getLoggerContext')) {
            $context = $this->getLoggerContext();
        }
        if ($this->hasLogger()) {
            $this->getLogger()->debug($message, $context);
        }
    }

    public function hasLogger() : bool {
        return $this->_logger instanceof Log\LoggerInterface;
    }

    public function getLogger() : Log\LoggerInterface {
        return $this->_logger;
    }

    public function setLogger(Log\LoggerInterface $logger) {
        $this->_logger = $logger;
    }

    public function removeLogger() {
        $this->_logger = NULL;
    }
}
