<?php ## Использование анонимных классов
  class Container
  {
    private $title = "Класс Container";
    protected $id = 1;

    public function anonym()
    {
      return new class($this->title) extends Container
      {

        private $name;

        public function __construct($title)
        {
          $this->name = $title;
        }

        public function print2()
        {
          echo "{$this->name} ({$this->id})";
        }
      };
    }
  }

  (new Container)->anonym()->print2();
?>