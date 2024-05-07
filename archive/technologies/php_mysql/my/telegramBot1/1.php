<?php

use RozbynDev\BonusSystem\Client;
use RozbynDev\Helper\Path;
use RozbynDev\Tables\BonusSystemTable;
use RozbynDev\Tables\Table;
use RozbynDev\Db\Mysqli;

require_once $_SERVER['DOCUMENT_ROOT'] . '/autoload.php';

echo '<pre>';
echo '</pre>';


//d(\RozbynDev\Tables\BonusSystemTable::makeTable());

//d(\RozbynDev\Api\Telegram::call('setMyDescription', ['description' => 'описание description']));
//d(\RozbynDev\Api\Telegram::call('setMyShortDescription', ['short_description' => 'короткое описание short_description']));
//d(\RozbynDev\Api\Telegram::call('setMyName', ['name' => 'имя name']));
//d(\RozbynDev\Api\Telegram::call('getMyCommands'));
d(\RozbynDev\Api\Telegram::call('setWebhook', [
    'url' => 'https://ezcsyandex.temp.swtest.ru/archive/technologies/php_mysql/my/telegramBot1/webhookTarget.php'
]));
//d(
//    \RozbynDev\Api\Telegram::call('setChatMenuButton', [
//        'menu_button' => [
//            'type' => 'default',
//            'text' => 'Веб апп',
//            'web_app' => ['url' => Path::getPathUrl(__DIR__.'/webApp.php')]
//        ],
//    ])
//);
d((new DateTime())->format(DATE_RFC2822));

//$client = Client::getById(720876963);
//d($client);
//$client->setNextAnswerType('name');
//d($client->getChangedFields());
//d($client->save());
//
//d(Table::validateInt('-376.1'));
//d(Table::validateString(9, 5));
//$date = 'TRUE';
//d(
//    Mysqli::fetchQuery(
//        'UPDATE ' . BonusSystemTable::getTableName() . ' SET isAdmin="' . $date . '" WHERE id=720876963'
//    )
//);

//d(
//    \RozbynDev\Api\Telegram::call('setMyCommands', [
//        'commands' => [
//            [
//                'command' => '/start',
//                'description' => 'Start the bot',
//            ],
//            [
//                'command' => '/forgetme',
//                'description' => 'Delete all information about you from our database',
//            ],
//            [
//                'command' => '/help',
//                'description' => 'Bot\'s why and how to use',
//            ],
//            [
//                'command' => '/settings',
//                'description' => 'Bot settings',
//            ],
//        ],
//    ])
//);

