<?php
  namespace PHP7;
  use \PHP7\Seo;
  use \PHP7\Tag;

  // Класс страницы
  class Page
  {
    // Подключаем трейты
    use Seo, Tag;

    // заголовок
    protected $title;
    // содержимое
    protected $content;
    // Конструктор класса
    public function __construct($title = '', $content = '')
    {
      $this->title = $title;
      $this->content = $content;
    }
  }
  function debug ($var) {
	  echo '<pre>';
	  var_dump($var);
	  echo '</pre>';
  }
?>