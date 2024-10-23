<?php

require_once "includes/database.php";
require_once "includes/authenticate.php";
require_once "includes/session.php";
require_once "includes/user_register.php";
require_once "includes/business_register.php";
require_once "./tools/vendor/autoload.php";
require_once "includes/config.php";
Session::initiateSession();

global $__site_config;
$__site_config = file_get_contents(__DIR__.'/../../../bizhub_config.json');

function get_config($key)
{
    global $__site_config;
    $array = json_decode($__site_config, true);

    // Split the key by '.' to support nested keys, e.g., 'google_oauth.client_id'
    $keys = explode('.', $key);

    // Traverse the array to get the nested value
    $value = $array;
    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        } else {
            return null; // Key not found
        }
    }

    return $value;
}
