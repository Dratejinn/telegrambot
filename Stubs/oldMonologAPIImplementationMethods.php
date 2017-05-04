<?php

class StubbyMcStub {

    public static function GetLogger(string $context = NULL) : Logger {
        //initialize basic logformatter
        if (self::$_LogFormatter === NULL) {
            self::_CreateDefaultLogFormatter();
        }
        //initialize basic channel length processor
        if (self::$_LogChannelLengthProcessor === NULL) {
            self::_CreateDefaultLogChannelLengthProcessor();
        }

        $logger = NULL;
        if (!ConfigManager::HasConfig('Log') || $context === NULL) {
            $logger = self::_GetDefaultLogger();
        } else {
            if (Registry::HasLogger(self::GLOBAL_LOGGER_PREFIX . $context)) {
                $logger = Registry::GetInstance(self::GLOBAL_LOGGER_PREFIX . $context);
            } else {
                $config = ConfigManager::GetConfig('Log');
                if (!isset($config[$context])) {
                    $logger = self::_GetDefaultLogger();
                    $logger = $logger->withName($context);
                } else {
                    $logLevel = $config[$context]['level'] ?? Logger::DEBUG;
                    $logger = new Logger($context);
                    $logger->pushProcessor(self::$_LogChannelLengthProcessor);
                    if (isset($config[$context]['cli']) && php_sapi_name() === 'cli') {
                        $cliLog = new StreamHandler(STDOUT, $logLevel);
                        $cliLog->setFormatter(self::$_LogFormatter);
                        $logger->pushHandler($cliLog);
                    }
                    if (isset($config[$context]['path'])) {
                        if (!is_array($config[$context]['path'])) {
                            $config[$context]['path'] = [$config[$context]['path']];
                        }
                        foreach ($config[$context]['path'] as $key => $path) {
                            $logHandler = new StreamHandler($path, $logLevel);
                            $logHandler->setFormatter(self::$_LogFormatter);
                            $logger->pushHandler($logHandler);
                        }
                    }
                }
                Registry::AddLogger($logger, self::GLOBAL_LOGGER_PREFIX . $context);
            }
        }
        return $logger;
    }

    private static function _GetDefaultLogger() : Logger {
        if (Registry::HasLogger('TBot-Default')) {
            return Registry::GetInstance('TBot-Default');
        }
        $logger = new Logger('TBot-Default');

        $dir = getcwd();
        if ($dir === FALSE) {
            $dir = __DIR__;
        }
        if (defined('DEVELOPMENT_MODE')) {
            if (DEVELOPMENT_MODE) {
                $logLevel = Logger::DEBUG;
            } else {
                $logLevel = Logger::NOTICE;
            }
        } else {
            //no DEVELOPMENT_MODE constant defined so just take the middle road
            $logLevel = Logger::INFO;
        }

        if (php_sapi_name() === 'cli') {
            $cliLog = new StreamHandler(STDOUT, $logLevel);
            $cliLog->setFormatter(self::$_LogFormatter);
            $logger->pushHandler($cliLog);
        }

        $logger->pushProcessor(self::$_LogChannelLengthProcessor);
        $stream = new StreamHandler($dir.'/TelegramBot.log', $logLevel);
        $stream->setFormatter(self::$_LogFormatter);
        $logger->pushHandler($stream);
        Registry::AddLogger($logger);
        return $logger;
    }

    private static function _CreateDefaultLogFormatter() {
        $format = "%datetime% | %channel% | %level_name% | %context.botname% | %message% %context% %extra%\n";
        //line formatter with output, default time, no inline breaks and leave empty context/extra
        self::$_LogFormatter = new LineFormatter($format, NULL, FALSE, TRUE);
    }

    private static function _CreateDefaultLogChannelLengthProcessor() {
        self::$_LogChannelLengthProcessor = new \Telegram\LogHelpers\LengthProcessor([
            'channel' => self::LOG_CHANNEL_LENGTH,
            'level_name' => self::LOG_LEVEL_LENGTH
            ], [
            'botname' => self::LOG_CONTEXT_BOTNAME_LENGTH
            ]);
    }
}
