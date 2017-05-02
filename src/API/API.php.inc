<?php

declare(strict_types = 1);

namespace Telegram\API;
use Monolog\Registry;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Formatter\LineFormatter;

final class API {

    const URL = 'https://api.telegram.org/bot%s/';

    const LOG_CHANNEL_LENGTH = 12;

    private static $_LogFormatter = NULL;
    private static $_LogChannelLengthProcessor = NULL;

    public static function CallMethod(string $method, Bot $bot, Base\Abstracts\ABaseObject $payload) {
        $url = self::_GetURL($method, $bot->getToken());
        return self::SendRequest($url, $payload);
    }

    public static function SendRequest(string $url, Base\Abstracts\ABaseObject $payload) {
        /* Create the headers */

        $payloadType = $payload->getPayloadType();
        $payload = $payload->getPayload();

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        if (ConfigManager::HasConfig('CA-certfile')) {
            curl_setopt($curl, CURLOPT_CAINFO, ConfigManager::GetConfig('CA-certfile'));
        }

        switch ($payloadType) {
            case 'JSON':
                $contentLength = strlen($payload);
                curl_setopt($curl, CURLOPT_HTTPHEADER, [
                    'Content-type: application/json',
                    'Content-Length: ' . $contentLength
                ]);
                break;
            case 'MultiPartFormData':
                curl_setopt($curl, CURLOPT_HTTPHEADER, [
                    'Content-type: multipart/form-data'
                ]);
                break;
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        // output the response
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $content = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if (!empty($error)) {
            $logger = self::GetLogger('API');
            $logger->error('Curl error: ' . $error);
            return NULL;
        }
        if (!is_string($content)) {
            return NULL;
        }
        /* Decode json string */
        return Base\Abstracts\ABaseObject::DecodeJSON($content);
    }

    private static function _GetURL(string $method, string $token) {
        $botUrl = sprintf(self::URL, $token);
        return $botUrl . $method;
    }

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
            if (Registry::HasLogger('TelegramBot-' . $context)) {
                $logger = Registry::GetInstance('TelegramBot-' . $context);
            } else {
                $config = ConfigManager::GetConfig('Log');
                if (!isset($config[$context])) {
                    $logger = self::_GetDefaultLogger();
                    $logger->withName();
                } else {
                    $logLevel = $config[$context]['level'] ?? Logger::DEBUG;
                    $logger = new Logger($context);
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
                Registry::AddLogger($logger, 'TelegramBot-' . $logger->getName());
            }
        }
        return $logger;
    }

    private static function _GetDefaultLogger() : Logger {
        if (self::$_LogFormatter === NULL) {
            self::_CreateDefaultLogFormatter();
        }
        if (self::$_LogChannelLengthProcessor === NULL) {
            self::_CreateDefaultLogChannelLengthProcessor();
        }

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
        $format = "%datetime% | %channel% | %level_name% | %message% %context% %extra%\n";
        //line formatter with output, default time, no inline breaks and leave empty context/extra
        self::$_LogFormatter = new LineFormatter($format, NULL, FALSE, TRUE);
    }

    private static function _CreateDefaultLogChannelLengthProcessor() {
        self::$_LogChannelLengthProcessor = new \Telegram\LogHelpers\ChannelLengthProcessor(self::LOG_CHANNEL_LENGTH);
    }
}
