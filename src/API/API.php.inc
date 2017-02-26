<?php

declare(strict_types = 1);

namespace Telegram\API;

final class API {

    const URL = 'https://api.telegram.org/bot%s/';

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
        curl_setopt($curl, CURLOPT_CAINFO, ConfigManager::GetConfig('CA-certfile'));

        switch($payloadType) {
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
}
