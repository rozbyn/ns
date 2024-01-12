<?php

namespace RozbynDev\Db;

use DateTime;
use mysqli_result;

class Mysqli
{
    protected static \mysqli $mysqliObj;

    public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    public static function getObj(): \mysqli
    {
        if (!isset(self::$mysqliObj)) {
            $dbConfigFilePath = $_SERVER['DOCUMENT_ROOT'] . '/Config/dbConfig.php';
            if (!is_file($dbConfigFilePath)) {
                throw new \RuntimeException('No db config file');
            }
            $config = include $dbConfigFilePath;
            self::$mysqliObj = new \mysqli(
                $config['host'],
                $config['user'],
                $config['password'],
                $config['name']
            );
            self::$mysqliObj->set_charset('utf8');
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
        return self::$mysqliObj;
    }


    public static function realEscapeString(string $string): string
    {
        return self::getObj()->real_escape_string($string);
    }


    public static function fetchQuery(string $query): bool|array
    {
        $result = self::getObj()->query($query);
        if ($result === true) {
            return true;
        }
        if ($result instanceof mysqli_result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return $result;
    }


    public static function isDateTimeStringInDBFormat(string $dateStr): bool
    {
        date_default_timezone_set('UTC');
        $date = DateTime::createFromFormat(self::DATE_TIME_FORMAT, $dateStr);
        return $date && ($date->format(self::DATE_TIME_FORMAT) === $dateStr);
    }



}

































































































































