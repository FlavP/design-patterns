<?php
require_once('BookInterface.php');
require_once('EReaderInterface.php');

class EReaderAdapter implements BookInterface
{
    private $ereader;

    public function __construct(EReaderInterface $kindle)
    {
        $this->ereader = $kindle;
    }

    public function open()
    {
        return $this->ereader->turnOn();
    }

    public function turnPage()
    {
        return $this->ereader->pressNextButton();
    }

}