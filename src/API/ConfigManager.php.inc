<?php

declare(strict_types = 1);

namespace Telegram\API;

final class ConfigManager {
    private static $_Configs = [];

    private function __construct() {
        //no
    }

    public static function AddConfig(string $name, $value) {
        self::$_Configs[$name] = $value;
    }

    public static function AddConfigFromJSONFile(string $configPath) : bool {
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

    public static function AddConfigFromINIFile(string $configPath, string $section) : bool {
        if (!file_exists($configPath)) {
            return FALSE;
        }
        $config = parse_ini_file($configPath, TRUE);
        if ($config === FALSE) {
            return FALSE;
        }
        
        if (!isset(self::$_Configs[$section])) {
            self::$_Configs[$section] = [];
        }

        if (!is_array(self::$_Configs[$section])) {
            throw new \Exception('Config section is not an array!');
        }

        foreach ($config as $key => $value) {
            self::$_Configs[$section][$key] = $value;
        }
        return TRUE;
    }

    public static function GetConfig(string $name) {
        if (self::HasConfig($name)) {
            return self::$_Configs[$name];
        }
        return NULL;
    }

    public static function HasConfig(string $name) : bool {
        return isset(self::$_Configs[$name]);
    }

    public function __invoke(string $name) {
        return self::GetConfig($name);
    }
}
