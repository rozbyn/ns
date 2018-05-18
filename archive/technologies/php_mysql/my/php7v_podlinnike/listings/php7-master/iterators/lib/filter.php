<?php ## Создание фильтра ExtensionFilter.

class DDirectoryIterator extends DirectoryIterator 
{
	public $id_id = null;
	public function __construct ($path)
	{
		$this->id_id = random_int(0, 1000) . ':' . microtime(true);
		parent::__construct($path);
	}
}
  class ExtensionFilter extends FilterIterator
  {
    // Фильтруемое расширение
    private $ext;
    // Итератор DirectoryIterator
    private $it;

    // Конструктор
    public function __construct(DirectoryIterator $it, $ext)
    {
       parent::__construct($it);
       $this->it = $it;
       $this->ext = $ext;
    }

    // Метод, определяющий, удовлетворяет текущий элемент
    // фильтру или нет
    public function accept()
    {
	 $ext = pathinfo($this->current(), PATHINFO_EXTENSION);
	 return $ext == $this->ext;
    }
  }
?>