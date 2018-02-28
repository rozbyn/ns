<?php

interface Observer
{
    public function changePrice($price);
}

class BitcoinObserver implements Observer
{
    /** @var array */
    private $messengers = [];

    public function addMessenger(Messenger $messenger)
    {
        $this->messengers[] = $messenger;
    }

    public function changePrice($price)
    {
        foreach ($this->messengers as $messenger) {
            $messenger->notify($price);
        }
    }
}

interface Messenger
{
    public function notify($price);
}

class EmailMessenger implements Messenger
{
    public function notify($price)
    {
        // Отправка письма на почту
        echo "Send to email" . PHP_EOL;
    }
}

class TelegramMessenger implements Messenger
{
    public function notify($price)
    {
        // Отправка письма на почту
        echo "Send to telegram" . PHP_EOL;
    }
}

class SmsMessenger implements Messenger
{
    public function notify($price)
    {
        // Отправка письма на почту
        echo "Send sms" . PHP_EOL;
    }
}

$observer = new BitcoinObserver();
$observer->addMessenger(new EmailMessenger);
$observer->addMessenger(new TelegramMessenger);
$observer->addMessenger(new SmsMessenger);

$price = 9999;

if ($price > 10000) {
    $observer->changePrice($price);
}
