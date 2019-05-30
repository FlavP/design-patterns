<?php

interface TemplateAbstractFactory{
    public function createTitleTemplate();
    public function createPageTemplate();
    public function getRenderer();
}

class TwigTemplateFactory implements TemplateAbstractFactory {
    public function createTitleTemplate()
    {
        return new TwigTitleTemplate();
    }

    public function createPageTemplate()
    {
        return new TwigPageTemplate($this->createTitleTemplate());
    }

    public function getRenderer()
    {
        return new TwigRenderer();
    }
}

class PHPTemplateFactory implements TemplateAbstractFactory {
    public function createTitleTemplate()
    {
        return new PHPTemplateTitleTemplate();
    }

    public function createPageTemplate()
    {
        return new PHPTemplatePageTemplate($this->createTitleTemplate());
    }

    public function getRenderer()
    {
        return new PHPTemplateRenderer();
    }
}

interface TitleRenderer {
    public function getTemplateString();
}

class TwigTitleTemplate implements TitleRenderer {
    public function getTemplateString()
    {
        return "<h1>{{ title }}</h1>";
    }
}

class PHPTemplateTitleTemplate implements TitleRenderer
{
    public function getTemplateString()
    {
        return "<h1><?= \$title; ?></h1>";
    }
}

interface PageTemplate {
    public function getTemplateString();
}

abstract class BasePageTemplate implements PageTemplate {
    protected $titleTemplate;

    public function __construct(TitleRenderer $titleTemplate)
    {
        $this->titleTemplate = $titleTemplate;
    }
}

class TwigPageTemplate extends BasePageTemplate {
    public function getTemplateString()
    {
        $renderTitle = $this->titleTemplate->getTemplateString();

        return <<<HTML
        <div class="page">
            $renderTitle
            <article class="content">{{ content }}</article>
        </div>
        HTML;
    }
}

class PHPTemplatePageTemplate extends BasePageTemplate
{
    public function getTemplateString()
    {
        $renderTitle = $this->titleTemplate->getTemplateString();

        return <<<HTML
        <div class="page">
            $renderTitle
            <article class="content"><?= \$content; ?></article>
        </div>
        HTML;
    }
}

interface TemplateRenderer{
    public function render($templateString, $arguments = []);
}

class TwigRenderer implements TemplateRenderer {
    public function render($templateString, $arguments = [])
    {
        return \Twig::render($templateString, $arguments);
    }
}

class PHPTemplateRenderer implements TemplateRenderer {
    public function render($templateString, $arguments = [])
    {
        extract($arguments);

        ob_start();
        eval(' ?>' . $templateString . '<?php ');
        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }
}

class RandomPage {
    public $title;
    public $content;

    public function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public function render(TemplateAbstractFactory $factory){
        $pageTemplate = $factory->createPageTemplate();
        $renderer = $factory->getRenderer();

        return $renderer->render($pageTemplate->getTemplateString(), [
            $this->title,
            $this->content
        ]);
    }
}

$page = new RandomPage('Sample Page', 'Body of the page');
echo "Testing actual rendering with the PHPTemplate factory:\n";
echo $page->render(new PHPTemplateFactory);

// Uncomment the following if you have Twig installed.

// echo "Testing rendering with the Twig factory:\n"; echo $page->render(new
// TwigTemplateFactory);