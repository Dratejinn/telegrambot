<?php

declare(strict_types = 1);

namespace Telegram\API;

final class ConfigManager {

    /**
     * All configs stored as an associative array
     * @var array
     */
    private static $_Configs = [];

    /**
     * Constructing a ConfigManager is not allowed
     * ConfigManager constructor.
     */
    private function __construct() {
        //no
    }

    /**
     * Method to add a config
     * @param string $name
     * @param $value
     */
    public static function AddConfig(string $name, $value) {
        self::$_Configs[$name] = $value;
    }

    /**
     * Method to add configs from a jsonfile
     * @param string $configPath
     * @return bool
     */
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

    /**
     * Method to add configs from an ini file
     * @param string $configPath
     * @param string $section
     * @return bool
     * @throws \Exception
     */
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

    /**
     * Method to get a config, if no config is found for $name then NULL is returned
     * @param string $name
     * @return mixed|null
     */
    public static function GetConfig(string $name) {
        if (self::HasConfig($name)) {
            return self::$_Configs[$name];
        }
        return NULL;
    }

    /**
     * Method to check if the ConfigManager has a config with provided $name
     * @param string $name
     * @return bool
     */
    public static function HasConfig(string $name) : bool {
        return isset(self::$_Configs[$name]);
    }
}
