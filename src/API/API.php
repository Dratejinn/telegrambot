<?php

declare(strict_types = 1);

namespace Telegram\API;

use Psr\Log;

final class API {

    const URL = 'https://api.telegram.org/bot%s/';

    private static $_Logger = NULL;

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
        if (ConfigManager::HasConfig('SSL-VerifyPeer')) {
            $verifyPeer = ConfigManager::GetConfig('SSL-VerifyPeer');
        } else {
            $verifyPeer = TRUE;
        }
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $verifyPeer);
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
            if (self::HasLogger()) {
                self::$_Logger->error('Curl error: ' . $error);
            }
            return NULL;
        }
        if (!is_string($content)) {
            if (self::HasLogger()) {
                self::$_Logger->error('Return value of curl handle is not of type string!');
            }
            return NULL;
        }
        /* Decode json string */
        return Base\Abstracts\ABaseObject::DecodeJSON($content);
    }

    private static function _GetURL(string $method, string $token) {
        $botUrl = sprintf(self::URL, $token);
        return $botUrl . $method;
    }

    public static function SetLogger(Log\LoggerAwareInterface $logger) {
        self::$_Logger = $logger;
    }

    public static function HasLogger() : bool {
        return self::$_Logger !== NULL;
    }
}
