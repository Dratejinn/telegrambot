<?php

declare(strict_types = 1);

namespace Telegram\API;

use Psr\Log;

final class API {

    const URL = 'https://api.telegram.org/bot%s/';

    /**
     * @var \Monolog\Logger
     */
    private static $_Logger = NULL;

    /**
     * @param string $method
     * @param \Telegram\API\Bot $bot
     * @param \Telegram\API\Base\Abstracts\ABaseObject $payload
     * @return \stdClass
     */
    public static function CallMethod(string $method, Bot $bot, Base\Abstracts\ABaseObject $payload) {
        $url = self::_GetURL($method, $bot->getToken());
        return self::SendRequest($url, $payload);
    }

    /**
     * @param string $url
     * @param \Telegram\API\Base\Abstracts\ABaseObject $payload
     * @return \stdClass
     */
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

        /* Check if connect timeout is set in the config. */
        if (ConfigManager::HasConfig('CURL-Connection-Timeout')) {
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, ConfigManager::GetConfig('CURL-Connection-Timeout'));
        } else {
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        }

        /* Check if transfer timeout is set in the config. */
        if (ConfigManager::HasConfig('CURL-Transfer-Timeout')) {
            curl_setopt($curl, CURLOPT_TIMEOUT, ConfigManager::GetConfig('CURL-Transfer-Timeout'));
        } else {
            curl_setopt($curl, CURLOPT_TIMEOUT, 60);
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
        $res = Base\Abstracts\ABaseObject::DecodeJSON($content, FALSE);
        if ($res === NULL) {
            $res = new \stdClass;
            $res->ok = FALSE;
            if (self::HasLogger()) {
                $err = json_last_error();
                switch ($err) {
                    case JSON_ERROR_NONE:
                        break;
                    case JSON_ERROR_DEPTH:
                        self::$_Logger->alert('JSON decode error: Maximum stack depth exceeded');
                        break;
                    case JSON_ERROR_STATE_MISMATCH:
                        self::$_Logger->alert('JSON decode error: Underflow or the modes mismatch');
                        break;
                    case JSON_ERROR_CTRL_CHAR:
                        self::$_Logger->alert('JSON decode error: Unexpected control character found');
                        break;
                    case JSON_ERROR_SYNTAX:
                        self::$_Logger->alert('JSON decode error: Syntax error, malformed JSON');
                        break;
                    case JSON_ERROR_UTF8:
                        self::$_Logger->alert('JSON decode error: Malformed UTF-8 characters, possibly incorrectly encoded');
                        break;
                    default:
                        self::$_Logger->alert('JSON decode error: Unknown error (' . $err . ')');
                        break;
                }
            }
        }
        return $res;
    }

    /**
     * @param string $method
     * @param string $token
     * @return string
     */
    private static function _GetURL(string $method, string $token) : string {
        $botUrl = sprintf(self::URL, $token);
        return $botUrl . $method;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public static function SetLogger(Log\LoggerInterface $logger) {
        self::$_Logger = $logger;
    }

    /**
     * @return bool
     */
    public static function HasLogger() : bool {
        return self::$_Logger !== NULL;
    }

    /**
     * Generates a V3 UUID
     *
     * @return string
     */
    public static function GenerateUUID() : string {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
