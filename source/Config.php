<?php

define("ROOT", "http://localhost/eletter");
define("THEMES", __DIR__."/../themes");
define("FILES", THEMES."/assets/files/");
define("TEMP", __DIR__."/../temp");
define("SITE", "#Eletter");

/**
 * Database config
 */
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "eletterbd",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

/**
 * Email config
 */
define("MAIL", [
    "host" => "smtp.gmail.com",
    "port" => "587",
    "user" => "contatoeletter@gmail.com",
    "passwd" => "eletterteste",
    "from_name" => "Eletter",
    "from_email" => "contatoeletter@gmail.com"
]);

/**
 * @param string|null $uri
 * @return string
 */
function url(string $uri = null): string
{
    if ($uri) {
        return ROOT . "/{$uri}";
    }

    return ROOT;
}