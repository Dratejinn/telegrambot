<?php

declare(strict_types = 1);

namespace Telegram\API;

final class ConfigManager {
    private static $_Configs = [];

    public static function AddConfig(string $name, $value) {
        self::$_Configs[$name] = $value;
    }

    public static function AddConfigFromFile(string $configPath) : bool {
        if (!file_exists($configPath)) {
            return FALSE;
        }
        $config = @file_get_contents($configPath);

        if ($config === FALSE) {
            return FALSE;
        }
        $json = json_decode($config);

        foreach ($json as $key => $value) {
            self::$_Configs[$key] = $value;
        }
        return TRUE;
    }

    public static function GetConfig(string $name) {
        if (isset(self::$_Configs[$name])) {
            return self::$_Configs[$name];
        }
        return NULL;
    }
}
