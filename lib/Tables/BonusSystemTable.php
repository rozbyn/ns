<?php

namespace RozbynDev\Tables;

use RozbynDev\Db\Mysqli;

class BonusSystemTable extends Table
{
    public static function getTableName(): string
    {
        return 'bonus_system_clients';
    }

    public static function getFieldsMap(): array
    {
        static $map = [
            'id' => ['INT PRIMARY KEY', ['int']],
            'name' => ['VARCHAR(255)', ['string', [255]]],
            'phone' => ['VARCHAR(18)', ['string', [18]]],
            'bonusCount' => ['INT', ['int']],
            'isAdmin' => ['BOOLEAN DEFAULT FALSE', ['boolean']],
            'nextAnswerType' => ['VARCHAR(255)', ['string', [255]]],

            'dateCreate' => ['DATETIME DEFAULT CURRENT_TIMESTAMP', ['dateTime']],
            'dateModify' => ['DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', ['dateTime']],
        ];
        return $map;
    }







}
