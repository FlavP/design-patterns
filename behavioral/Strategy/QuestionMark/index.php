<?php

abstract class Question{
    protected $marker;
    protected $content;

    public function __construct(Marker $marker, $content)
    {
        $this->marker = $marker;
        $this->content = $content;
    }

    public function mark(){
        return $this->marker->mark();
    }
}

class TextQuestion extends Question {
    // logic for text questions
}

class AvQuestion extends Question {
    // logic for text audio-visual questions
}

abstract class Marker {
    protected $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    abstract public function mark($response);
}

class MarkLogicMarker extends Marker {
    private $engine;

    public function __construct($test)
    {
        parent::__construct($test);
        $this->engine = new MarkParse($test);
    }

    public function mark($response)
    {
        return $this->engine->evaluate($response);
    }
}

class MatchMarker extends MarkLogicMarker {
    public function mark($response)
    {
        return ($this->test == $response);
    }
}

class RegexpMarker extends MarkLogicMarker {
    public function mark($response)
    {
        return (preg_match("$this->test", $response) === 1);
    }
}