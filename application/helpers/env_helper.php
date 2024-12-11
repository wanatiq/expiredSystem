<?php
if (!function_exists('getenv_ci')) {
    function getenv_ci($key, $default = null)
    {
        // Load the .env file once
        static $envData = null;
        if ($envData === null) {
            $envFile = FCPATH . '.env';
            if (file_exists($envFile)) {
                $envData = parse_ini_file($envFile, false, INI_SCANNER_RAW);
            } else {
                $envData = [];
            }
        }

        // Return the value or default
        return isset($envData[$key]) ? $envData[$key] : $default;
    }
}
