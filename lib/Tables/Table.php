<?php

namespace RozbynDev\Tables;

use DateTime;
use RozbynDev\Db\Mysqli;

abstract class Table
{


    public static function makeTable(): bool
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . static::getTableName() . '`(';
        foreach (static::getFieldsMap() as $fieldName => $fieldDescrArr) {
            $fieldSqlParams = $fieldDescrArr[0];
            $sql .= "`$fieldName` $fieldSqlParams,";
        }
        $sql[strlen($sql) - 1] = ')';
        return (bool)Mysqli::fetchQuery($sql);
    }


    /**
     * @throws \Exception
     */
    public static function getUpdateFieldsSql(array $fields): string
    {
        $arSqls = [];
        $preparedFields = static::prepareFields($fields);
        foreach ($preparedFields as $fieldName => $fieldValue) {
            $arSqls[]= "$fieldName='$fieldValue'";
        }
        return implode(', ', $arSqls);
    }


    /**
     * @throws \Exception
     */
    public static function prepareFields(array $fields): array
    {
        $preparedFields = [];
        foreach ($fields as $fieldName => $fieldValue) {
            $preparedFields[$fieldName] = static::prepareField($fieldName, $fieldValue);
        }
        return $preparedFields;
    }


    public static function prepareField(string $fieldName, mixed $fieldValue): string
    {
        $map = static::getFieldsMap();
        if (isset($map[$fieldName])) {
            [$type, $args] = $map[$fieldName][1];
            if (empty($args)) {
                $args = [];
            }
            $prepareFunc = __CLASS__ . '::prepare' . ucfirst($type);
            $validateFunc = __CLASS__ . '::validate' . ucfirst($type);
            if (!is_callable($prepareFunc) || !is_callable($validateFunc)) {
                throw new \RuntimeException('Unknown field type `' . $fieldName . '`, type: ' . $type);
            }
            $preparedValue = $prepareFunc($fieldValue);
            array_unshift($args, $preparedValue);
            $validateResult = call_user_func_array($validateFunc, $args);
            if (!$validateResult) {
                throw new \RuntimeException('Invalid value for field `' . $fieldName . '`, type: ' . $type);
            }
            return $preparedValue;
        }
        throw new \RuntimeException("No field $fieldName in table " . static::getTableName());
    }


    public static function prepareInt(mixed $value): string
    {
        return (string)(int)$value;
    }


    public static function prepareBoolean(mixed $value): string
    {
        $value = (bool)$value;
        return $value ? "1" : "0";
    }


    public static function prepareDateTime(mixed $value): string
    {
        if (is_object($value) && is_subclass_of($value, DateTime::class)) {
            return "'".$value->format(Mysqli::DATE_TIME_FORMAT)."'";
        }
        return static::prepareString($value);
    }


    public static function prepareString(mixed $value): string
    {
        return Mysqli::realEscapeString((string)$value);
    }


    public static function validateInt(mixed $value): bool
    {
        return (string)$value === (string)(int)$value;
    }


    public static function validateString(mixed $value, int $length = 0): bool
    {
        return is_string($value) && ($length === 0 || strlen($value) <= $length);
    }


    public static function validateBoolean(mixed $value): bool
    {
        return $value === 1 || $value === 0 || $value === '1' || $value === '0';
    }


    public static function validateDateTime(mixed $value): bool
    {
        return is_string($value) && Mysqli::isDateTimeStringInDBFormat($value);
    }


    abstract public static function getTableName(): string;

    abstract public static function getFieldsMap(): array;


}
