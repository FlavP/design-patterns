<?php

class RequestHelper{
    }

abstract class ProcessRequest{
    abstract function process(RequestHelper $request);
}

class MainProcess extends ProcessRequest{
    public function process(RequestHelper $request)
    {
        print __CLASS__ . ": doing something useful with the request\n";
    }
}

abstract class ProcessDecorator extends ProcessRequest {
    protected $request;

    public function __construct(ProcessRequest $request)
    {
        $this->request = $request;
    }

    public function getRequest(){
        return $this->request;
    }
}

class HtmlRequest extends ProcessDecorator {
    public function process(RequestHelper $request)
    {
        print __CLASS__ . " decorating " . $this->request->process($request) . "\n";
    }
}

class HttpsRequest extends ProcessDecorator {
    public function process(RequestHelper $request)
    {
        print __CLASS__ . " decorating " . $this->request->process($request) . "\n";
    }
}

$process = new HttpsRequest(new HtmlRequest(new MainProcess()));
$process->process(new RequestHelper());