<?php

interface Downloader{
    public function download($url);
}

class SimpleDownloader implements Downloader{
    public function download($url)
    {
        echo "Downloading a file from the Internet\n";
        $result = "Downloaded the file " . $url;
        echo "Downloaded " . strlen($url) . " content";
        return $result;
    }
}

class ProxyDownloader implements Downloader{
    private $downloader;
    private $cache = [];
    public function __construct(SimpleDownloader $downloader)
    {
        $this->downloader = $downloader;
    }

    public function download($url)
    {
        if (!isset($this->cache[$url])){
            $this->cache[$url] = $this->downloader->download($url);
        } else {
            echo "File retrieved from cache\n";
        }
        return $this->cache[$url];
    }
}

function clientCode(Downloader $downloader){
    echo $downloader->download("http://www.example.com");
}

$simpleDownloader = new SimpleDownloader();
clientCode($simpleDownloader);
clientCode($simpleDownloader);

//We use the same url twice, to see the optimization

$proxyDownloader = new ProxyDownloader($simpleDownloader);
clientCode($proxyDownloader);
clientCode($proxyDownloader);
