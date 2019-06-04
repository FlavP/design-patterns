<?php

interface Logger {
    public function log($data);
}

class LogToFile implements Logger {

    public function log($data)
    {
        var_dump("Log the data to a file");
    }
}

class LofToDatabase implements Logger  {

    public function log($data)
    {
        var_dump("Log the data to a database");
    }
}

class LogToXWebService implements Logger  {

    public function log($data)
    {
        var_dump("Log the data to a Saas site");
    }
}

class App {

    public function log($data, Logger $logger = null) {
        $logger = $logger ?: new LogToFile();
        $logger->log($data);
    }
}

$apper = new App();
$apper->log('Some info', new LogToXWebService());