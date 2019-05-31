<?php

class Page
{
    private $title;
    private $content;
    /**
     * @var Author
     */
    private $author;
    /**
     * @var DateTime
     */
    private $date;
    private $comments = [];

    public function __construct($title, $content, Author $author)
    {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->author->addPage($this);
        $this->date = new DateTime();
    }

    public function addComment($comment)
    {
        $this->comments[] = $comment;
    }

    public function __clone()
    {
        $this->title = "Copy of " . $this->title;
        $this->author->addPage($this);
        $this->comments = [];
        $this->date = new DateTime();
    }
}

class Author
{
    private $name;
    private $pages = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addPage($page)
    {
        $this->pages[] = $page;
    }
}

function clientCode(){
    $page1 = new Page("First Article", "Content of First Article", new Author("John Smith"));
    $page1->addComment("First Comment");
    $page1->addComment("Second Comment");
    $page2 = clone $page1;
    print_r($page2);
}

clientCode();

