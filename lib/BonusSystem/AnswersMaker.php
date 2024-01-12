<?php

namespace RozbynDev\BonusSystem;

use JsonException;
use RozbynDev\Api\Telegram;
use RozbynDev\Helper\Logger;
use RozbynDev\Helper\Path;

class AnswersMaker
{

    protected bool $needSendDefaultAnswer = true;
    protected static string $webAppUrl;


    public function __construct(
        protected Client $client,
        protected array $data,

    ) {
    }


    /**
     * @return string
     */
    public static function getWebAppUrl(): string
    {
        return self::$webAppUrl;
    }

    /**
     * @param string $webAppUrl
     */
    public static function setWebAppUrl(string $webAppUrl): void
    {
        self::$webAppUrl = $webAppUrl;
    }


    public function makeAnswer()
    {
        $this->checkCommandsAndCallbacks();
        if (is_null($this->client->getName())) {
            if ($this->client->getNextAnswerType() === 'name') {
                $this->saveClientName();
            }
            if (is_null($this->client->getName())) {
                return $this->askClientName();
            }
        }
        if (empty($this->client->getPhone())) {
            if ($this->client->getNextAnswerType() === 'phone' && $this->saveClientPhone()) {
                $this->sendSuccessRegisterMessage();
            }
            if (empty($this->client->getPhone())) {
                return $this->askClientPhone();
            }
        }
        return $this->needSendDefaultAnswer ? $this->sendDefaultMessage() : true;
    }

    public function sendMessage(array $params)
    {
        $params['chat_id'] = $this->client->getId();
        return Telegram::call('sendMessage', $params);
    }


    public static function getFirstMetParams(): array
    {
        return [
            'text' => 'Здравствуйте, рады приветствовать вас в нашем телеграмм-боте. '
                . 'Для того, что-бы пользоваться всеми преимуществами бота вам нужно '
                . 'зарегистрироваться, указав ваше имя и номер телефона.',
        ];
    }


    public function sendSuccessRegisterMessage(): array
    {
        return $this->sendMessage([
            'text' => 'Вы успешно зарегистрировались',
        ]);
    }


    public function askClientName(): array
    {
        $params = [
            'text' => 'Как вас зовут?',
            'reply_markup' => [
                'force_reply' => true,
                'input_field_placeholder' => 'Имя',
                'selective' => false,
            ],
        ];
        $sendResult = $this->sendMessage($params);
        if ($sendResult['ok'] === true && $sendResult['result']['message_id'] > 0) {
            $this->client->setNextAnswerType('name');
            $this->client->save();
        }
        return $sendResult;
    }

    public function saveClientName()
    {
        $mayBeName = $this->data['message']['text'];
        $re = '/^[а-яА-ЯёЁ a-zA-Z]{2,}$/u';
        if (preg_match($re, $mayBeName)) {
            $mayBeName = mb_convert_case($mayBeName, MB_CASE_TITLE, 'UTF-8');
            $this->client->setName($mayBeName);
            $this->client->setNextAnswerType('');
            $this->client->save();
            $this->sendMessage(['text' => 'Рады знакомству, ' . $mayBeName]);
        } else {
            $this->sendMessage(['text' => 'Это не похоже на имя)']);
        }
    }

    public function saveClientPhone()
    {
        $phone = '';
        if (
            !empty($this->data['message']['contact']['phone_number'])
            && $this->data['message']['contact']['user_id'] === $this->client->getId()
        ) {
            $phone = preg_replace('/\D/', '', $this->data['message']['contact']['phone_number']);
        } elseif (preg_match('/^7\d{10}$/', $this->data['message']['text'])) {
            $phone = $this->data['message']['text'];
        }
        if (!empty($phone)) {
            $this->client->setPhone($phone);
            $this->client->setNextAnswerType('');
            $this->client->save();
            $this->sendMessage([
                'text' => 'Принято! Ваш телефон: ' . $phone,
                'reply_markup' => ['remove_keyboard' => true],
            ]);
            return true;
        }
        $this->sendMessage(['text' => 'Номер не распознан(']);
        return false;
    }


    public function askClientPhone()
    {
        $params = [
            'text' => 'Ваш номер телефона? '
                . 'Вы можете нажать на кнопку "Отправить номер телефона, привязанный к Telegram", '
                . 'либо ввести вручную (должен начинаться с цифры "7", затем 10 цифр)',
            'reply_markup' => [
                'force_reply' => true,
                'input_field_placeholder' => '70009990099',
                'selective' => false,
                'keyboard' => [
                    [['text' => 'Отправить номер телефона, привязанный к Telegram', 'request_contact' => true]],
                ],
                'one_time_keyboard' => true,
            ],
        ];
        $sendResult = $this->sendMessage($params);
        if ($sendResult['ok'] === true && $sendResult['result']['message_id'] > 0) {
            $this->client->setNextAnswerType('phone');
            $this->client->save();
        }
        return $sendResult;
    }

    public function sendDefaultMessage()
    {
        return $this->sendMessage([
            'text' => 'Выберите что-бы вы хотели сделать дальше',
            'reply_markup' => $this->getDefaultInlineKeyboardConfig(),
        ]);
    }


    public function getDefaultInlineKeyboardConfig()
    {
        return [
            'inline_keyboard' => [
                [
                    ['text' => 'Информация обо мне 👤', 'callback_data' => 'showAccountInfo'],
                    ['text' => 'История начислений 📈', 'callback_data' => 'showHistory'],
                ],
            ],
        ];
    }

    public function checkCommandsAndCallbacks(): void
    {
        foreach ($this->getCommandsData() as $commandName => $commandParams) {
            $this->handleCommand($commandName, $commandParams);
        }
        $this->handleCallbacks();
    }


    public function getCommandsData(): array
    {
        $commands = [];
        if (!empty($this->data['message']['entities']) && !empty($this->data['message']['text'])) {
            foreach ($this->data['message']['entities'] as $entity) {
                if ($entity['type'] === 'bot_command') {
                    $cmd = mb_substr($this->data['message']['text'], $entity['offset'], $entity['length']);
                    $commands[$cmd] = $entity;
                }
            }
        }
        return $commands;
    }

    public function handleCommand(string $commandName, array $commandParams)
    {
        switch ($commandName) {
            case '/start':
                if (is_string($this->client->getName()) && is_string($this->client->getPhone())) {
                    $messageParams = [];
                    $messageParams['text'] = 'Вы уже зарегистрировались, ' . $this->client->getName()
                        . '. Ваш номер телефона: ' . $this->client->getPhone(
                        ) . '. Можете полноценно пользоваться ботом.';
                    $this->sendMessage($messageParams);
                }
                break;
            case '/forgetme':
                if (Client::deleteById($this->client->getId())) {
                    $this->sendMessage(['text' => 'Ваша информация стерта из нашей базы данных']);
                    exit;
                }
                break;
            case '/settings':
                $this->sendMessage([
                    'text' => 'Нажмите на кнопку ниже чтобы открыть приложение',
                    'reply_markup' => [
                        'inline_keyboard' => [
                            [
                                [
                                    'text' =>'Открыть приложение',
                                    'web_app' => ['url' => self::getWebAppUrl()]
                                ],
                            ],
                        ],
                    ]
                ]);
                $this->needSendDefaultAnswer = false;
                break;
            default:
                break;
        }
    }

    public function handleCallbacks()
    {
        if (empty($this->data['callback_query']['data'])) {
            return;
        }
        switch ($this->data['callback_query']['data']) {
            case 'showAccountInfo':
                $this->editCallbackMessageText(
                     'Имя: ' . $this->client->getName() . PHP_EOL
                    . 'Телефон: ' . $this->client->getPhone(). PHP_EOL
                    . 'Количество бонусов: ' . ($this->client->getBonusCount()??0). PHP_EOL
                    . 'Дата регистрациии: ' . $this->client->getCreateDate()->format('d.m.Y H:i:s'). PHP_EOL
                    . 'Дата последнего изменения профиля: ' . $this->client->getModifyDate()->format('d.m.Y H:i:s')
                );
                $this->answerCallback('👍');
                $this->needSendDefaultAnswer = false;
                break;
            case 'showHistory':
                $this->editCallbackMessageText(
                     '+ 17 бонусов, 29.04.2019 19:55'.PHP_EOL
                    .'+ 39 бонусов, 04.05.2019 13:37'.PHP_EOL
                    .'+ 12 бонусов, 19.06.2023 15:09'.PHP_EOL
                    .'- 68 бонусов, 13.02.2024 19:00'.PHP_EOL
                );
                $this->answerCallback('👍');
                $this->needSendDefaultAnswer = false;

        }
    }


    public function editCallbackMessageText(string $newText)
    {
        if ($this->data['callback_query']['message']['text'] !== $newText) {
            Telegram::call('editMessageText', [
                'message_id' => $this->data['callback_query']['message']['message_id'],
                'chat_id' => $this->data['callback_query']['message']['chat']['id'],
                'text' => $newText,
                'reply_markup' => $this->getDefaultInlineKeyboardConfig(),
            ]);
        }
    }


    /**
     * @param string|null $text
     * @param bool $showAlert
     * @param string|null $url
     * @return array|null
     * @throws JsonException
     */
    public function answerCallback(?string $text = null, bool $showAlert = false, ?string $url = null): ?array
    {
        if (empty($this->data['callback_query']['id'])) {
            return null;
        }
        $params = ['callback_query_id' => $this->data['callback_query']['id']];
        if (!is_null($text)) {
            $params['text'] = $text;
        }
        if ($showAlert) {
            $params['show_alert'] = true;
        }
        if (!is_null($url)) {
            $params['url'] = $url;
        }
        return Telegram::call('answerCallbackQuery', $params);
    }


}


