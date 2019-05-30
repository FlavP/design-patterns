<?php

class CSVFileIterator implements \Iterator {
    const ROW_SIZE = 4096;

    protected $filePointer = null;
    protected $delimiter = null;
    protected $currentElement = null;
    protected $rowCounter = null;

    /**
     * The constructor tries to open the CSV file. It throws an exception on
     * failure.
     *
     * @param string $file The CSV file.
     * @param string $delimiter The delimiter.
     *
     * @throws \Exception
     */
    public function __construct($file, $delimiter = ',')
    {
        try{
            $this->filePointer = fopen($file, 'rb');
            $this->delimiter = $delimiter;
        } catch (Exception $e){
            throw new Exception('The file "' . $file . '" cannot be read.');
        }
    }

    /**
     * reset the file pointer
     */
    public function rewind()
    {
        $this->rowCounter = 0;
        rewind($this->filePointer);
    }

    /**
     * This method returns the current CSV row as a 2-dimensional array.
     *
     * @return array The current CSV row as a 2-dimensional array.
     */
    public function current()
    {
        $this->currentElement = fgetcsv($this->filePointer, self::ROW_SIZE, $this->delimiter);
        $this->rowCounter++;
        return $this->currentElement;
    }

    public function key()
    {
        return $this->rowCounter;
    }

    /**
     * This method checks if the end of file has been reached.
     *
     * @return bool Returns true on EOF reached, false otherwise.
     */
    public function next()
    {
        if(is_resource($this->filePointer))
            return !feof($this->filePointer);
        return false;
    }

    /**
     * @return bool If the next row is a valid row.
     */
    public function valid()
    {
        if(!$this->next()){
            if (is_resource($this->filePointer))
                fclose($this->filePointer);
            return false;
        }
        return true;
    }
}

/**
 * The client code.
 */
$csv = new CsvIterator(__DIR__ . '/cats.csv');

foreach ($csv as $key => $row) {
    print_r($row);
}
