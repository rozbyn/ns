<?php

namespace RozbynDev\Tables;

use RozbynDev\Db\Mysqli;

class CommandsQueueTable extends Table
{
    public static function getTableName(): string
    {
        return 'commands_queue';
    }

    public static function getFieldsMap(): array
    {
        static $map = [
            'id' => ['INT PRIMARY KEY', ['int']],
            'function' => ['VARCHAR(255)', ['string', [255]]],
            'data' => ['MEDIUMTEXT', ['string', [16777215]]],
            'status' => ['INT', ['int']],
            
            'inclideFile' => ['VARCHAR(2048)', ['string', [2048]]],
            'dateCreate' => ['DATETIME DEFAULT CURRENT_TIMESTAMP', ['dateTime']],
            'dateModify' => ['DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', ['dateTime']],
        ];
        return $map;
    }







}
