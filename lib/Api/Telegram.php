<?php

namespace RozbynDev\Api;

use JsonException;
use RozbynDev\Config\TelegramBot1Key;
use RozbynDev\Helper\Logger;

class Telegram
{

    protected static bool $useJson = true;
    protected static ?Logger $logger;

    /**
     * @return Logger|null
     */
    public static function getLogger(): ?Logger
    {
        return self::$logger;
    }

    /**
     * @param Logger|null $logger
     * @return void
     */
    public static function setLogger(?Logger $logger): void
    {
        self::$logger = $logger;
    }


    /**
     * @param string $method
     * @param array $params
     * @return array|null
     * @throws JsonException
     */
    public static function call(string $method, array $params = []): ?array
    {
        $ch = curl_init('https://api.telegram.org/bot' . TelegramBot1Key::getApiKey() . '/' . $method);
        curl_setopt($ch, CURLOPT_POST, 1);
        if (!empty($params)) {
            if (self::$useJson) {
                $paramsStr = json_encode($params, JSON_THROW_ON_ERROR);
            } else {
                $paramsStr = http_build_query($params);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paramsStr);
        }
        if (self::$useJson) {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $json = curl_exec($ch);
        curl_close($ch);
        return $json === false ? null : (array)json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }


    /**
     * @param int $chatId
     * @param array $params
     * @return array|null
     * @throws JsonException
     */
    public static function sendMessage(int $chatId, array $params = []): ?array
    {
        $params['chat_id'] = $chatId;
        return self::call('sendMessage', $params);
    }

}
