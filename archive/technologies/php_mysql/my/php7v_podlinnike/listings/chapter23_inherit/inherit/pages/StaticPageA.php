<?php ## Статические страницы
  require_once "CachedA.php";
  class StaticPage extends Cached
  {
    // Конструктор класса
    public function __construct($id)
    {
      // Проверяем нет ли такой страницы в кэше
      if ($this->isCached($this->id($id))) {
        // Есть, инициализируем объект содержимым кэша
        parent::__construct($this->title(), $this->content());
      } else {
        // Данные пока не кэшированы, извлекаем 
        // содержимое из базы данных
        // $query = "SELECT * FROM static_pages WHERE id = :id LIMIT 1"
        // $sth = $dbh->prepare($query);
        // $sth = $dbh->execute($query, [$id]);
        // $page = $sth->fetch(PDO::FETCH_ASSOC);
        // parent::__construct($page['title'], $page['title']);
        parent::__construct("Контакты".'->'.__CLASS__, "Содержимое страницы Контакты".'->'.__CLASS__);
      }
    }

    // Уникальный ключ для кэша
    public function id($name)
    {
      return "static_page_{$name}";
    }
  }
?>