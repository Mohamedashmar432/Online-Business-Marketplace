<?php

class Config
{
    private static $__site_config = null;

    /**
     * Load the configuration file and parse the JSON.
     */
    public static function loadConfig()
    {
        if (self::$__site_config === null) {
            $configPath = __DIR__ . '/../../../../bizhub_config.json';

            // Check if the file exists before attempting to load it
            if (file_exists($configPath)) {
                $configData = file_get_contents($configPath);
                self::$__site_config = json_decode($configData, true);
            } else {
                throw new Exception("Configuration file not found: " . $configPath);
            }
        }
    }

    /**
     * Get configuration value by key.
     *
     * @param string $key The key, supporting dot notation for nested keys.
     * @return mixed|null The value or null if key is not found.
     */
    public static function get_config($key)
    {
        // Ensure config is loaded
        self::loadConfig();

        // Split the key by '.' to support nested keys, e.g., 'google_oauth.client_id'
        $keys = explode('.', $key);

        // Traverse the array to get the nested value
        $value = self::$__site_config;
        foreach ($keys as $k) {
            if (isset($value[$k])) {
                $value = $value[$k];
            } else {
                return null; // Key not found
            }
        }

        return $value;
    }
}
