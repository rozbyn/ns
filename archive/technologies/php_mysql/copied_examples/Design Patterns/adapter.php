<?php

class Vk
{
    public function post($message)
    {
        echo $message . PHP_EOL;
    }
}

interface SocialAdapter
{
    public function post($message);
}

class VkAdapter implements SocialAdapter
{

    private $vk;

    public function __construct(Vk $vk)
    {
        $this->vk = $vk;
    }

    public function post($message)
    {
        $this->vk->post($message);
    }
}

$adapter = new VkAdapter(new Vk());
$adapter->post('Сообщение 1');
$adapter->post('Сообщение 2');
$adapter->post('Сообщение 3');