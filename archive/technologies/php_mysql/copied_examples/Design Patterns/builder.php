<pre>
<?php

interface NewsBuilderInterface
{
    public function getText();
    public function getCategories();
    public function getStatistics();

    public function build($id);
}

class NewsBuilder implements NewsBuilderInterface
{
    private $newsId;

    public function getCategories()
    {
        $data = [
            1 => ['category 1', 'category 2', 'category 3'],
            2 => ['category 3', 'category 2', 'category 5'],
        ];

        return $data[$this->newsId] ?? null;
    }

    public function getStatistics()
    {
        $data = [
            1 => ['visits' => 109, 'comments' => 5],
            2 => ['visits' => 328, 'comments' => 12],
        ];

        return $data[$this->newsId] ?? null;
    }

    public function getText()
    {
        $data = [
            1 => 'Text 1',
            2 => 'Text 2',
        ];

        return $data[$this->newsId] ?? null;
    }

    public function build($id)
    {
        $this->newsId = $id;

        $post = new Post;
        $post->setId($this->newsId);
        $post->setCategories($this->getCategories());
        $post->setStatistics($this->getStatistics());
        $post->setText($this->getText());

        return $post;
    }
}

class Post
{
    private $id;
    private $categories;
    private $statistics;
    private $text;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getStatistics()
    {
        return $this->statistics;
    }

    public function setStatistics($statistics)
    {
        $this->statistics = $statistics;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }
}

$builder = new NewsBuilder();

$post = $builder->build(1);

echo $post->getId() . PHP_EOL;
print_r($post->getCategories()) . PHP_EOL;
print_r($post->getStatistics()) . PHP_EOL;
echo $post->getText() . PHP_EOL;