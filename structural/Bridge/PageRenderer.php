<?php

// paternul bridge asigura functionalitatea a 2 abstractiuni diferite

abstract class Page{
    private $renderer;
    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function changeRenderer(Renderer $renderer){
        $this->renderer = $renderer;
    }

    abstract function view();
}

class SimplePage extends Page{
    private $title;
    private $content;
    private $renderer;

    public function __construct(Renderer $renderer, $title, $content)
    {
        $this->renderer = $renderer;
        $this->title = $title;
        $this->content = $content;
    }

    public function view(){
        return $this->renderer->renderParts([
            $this->renderer->renderHeader(),
            $this->renderer->renderTitle($this->title),
            $this->renderer->renderTextBlock($this->content),
            $this->renderer->renderFooter(),
        ]);
    }
}

class ProductPage extends Page{
    private $product;
    private $renderer;

    public function __construct(Renderer $renderer, Product $product)
    {
        $this->renderer = $renderer;
        $this->product = $product;
    }

    public function view(){
        return $this->renderer->renderParts([
            $this->renderer->renderHeader(),
            $this->renderer->renderTitle($this->product->getTitle()),
            $this->renderer->renderTextBlock($this->product->getDescription()),
            $this->renderer->renderImage($this->product->getImage()),
            $this->renderer->renderLink("/cart/add/" . $this->product->getId(), "Add to Cart"),
            $this->renderer->renderFooter(),
        ]);
    }
}

// Asta e helperul pentru ProductPage
class Product{
    private $id, $title, $description, $image, $price;

    public function __construct(
        $id,
        $title,
        $description,
        $image,
        $price
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

}

interface Renderer{
    public function renderHeader();
    public function renderTitle($title);
    public function renderTextBlock($body);
    public function renderImage($url);
    public function renderLink($link, $title);
    public function renderFooter();
    public function renderParts($partsArray);
}

class HtmlRenderer implements Renderer {

    public function renderTitle($title){
        return '<h3>' . $title . '</h3>';
    }

    public function renderTextBlock($body){
        return '<div class="text">' . $body . '</div>';
    }

    public function renderImage($url){
        return "<img src='$url'>";
    }

    public function renderLink($url, $title){
        return "<a href='$url'>$title</a>";
    }

    public function renderHeader(){
        return '<html><body>';
    }

    public function renderFooter(){
        return '</html></body>';
    }

    public function renderParts($partsArray){
        return implode("\n", $partsArray);
    }
}

class JsonRenderer implements Renderer {
    public function renderTitle($title){
        return '"title" : "' . $title . '"';
    }

    public function renderTextBlock($body){
        return '"text" : "' . $body . '"';
    }

    public function renderImage($image){
        return '"img" : "' . $image . '"';
    }

    public function renderLink($url, $title){
        return '"link": {"href": "' . $url . '", "title": "' . $title . '""}';
    }

    public function renderHeader(){
        return '';
    }

    public function renderFooter(){
        return '';
    }

    public function renderParts($partsArray){
        return "{\n" . implode(",\n", array_filter($partsArray)) . "\n}";;
    }
}

function clientCode(Page $page){
    echo $page->view();
}

$htmlRen = new HtmlRenderer;
$jsonRen = new JsonRenderer;

$simple = new SimplePage($htmlRen, "Page Title", "<p>A little bit of content</p>");
echo "Html view of the page";
clientCode($simple);
$simple->changeRenderer($jsonRen);
echo "Json view of the page";
clientCode($simple);

$product = new Product("123", "Star Wars, episode1",
    "A long time ago in a galaxy far, far away...",
    "/images/star-wars.jpeg", 39.95);

$productPage = new ProductPage($htmlRen, $product);
echo "Html view of the page";
clientCode($productPage);
$productPage->changeRenderer($jsonRen);
echo "Json view of the page";
clientCode($productPage);



