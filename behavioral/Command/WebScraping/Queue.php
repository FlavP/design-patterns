<?php
require_once("Command.php");

/**
 * The Queue class acts as an Invoker. It stacks the command objects and
 * executes them one by one. If the script execution is suddenly terminated, the
 * queue and all its commands can easily be restored, and you won't need to
 * repeat all of the executed commands.
 * Class Queue
 */
class Queue
{
    private $db;

    /**
     * Queue constructor.
     */
    public function __construct()
    {
        $this->db = new \SQLite3(__DIR__ . '/commands.sqlite',
            SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

        $this->db->query('CREATE TABLE IF NOT EXISTS "commands" (
            "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            "command" TEXT,
            "status" INTEGER
        )');
    }

    /**
     * @return bool
     */
    public function isEmpty(){
        $query = 'SELECT COUNT("id") FROM "commands" WHERE status = 0';
        return $this->db->querySingle($query) === 0;
    }

    /**
     * @param Command $command
     */
    public function addCommand(Command $command){
        $query = 'INSERT INTO commands (command, status) VALUES (:command, :status)';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':command', base64_encode(serialize($command)));
        $statement->bindValue(':status', $command->getStatus());
        $statement->execute();
    }

    /**
     * @return Command
     */
    public function getCommand(){
        $query = 'SELECT * FROM "commands" WHERE "status" = 0 LIMIT 1';
        $record = $this->db->querySingle($query, true);
        $command = unserialize(base64_decode($record["command"]));
        $command->id = $record['id'];

        return $command;
    }

    /**
     * @param Command $command
     */
    public function updateCommand(Command $command){
        $query = 'UPDATE commands SET status = :status WHERE id = :id';
        $record = $this->db->prepare($query);
        $record->bindValue(':status', $command->getStatus());
        $record->bindValue(':id', $command->getId());
        $record->execute();
    }

    /**
     * Aici verifica daca Queue este goala si cat timp nu este goala
     * executa query-uri
     */
    public function work(){
        if(!$this->isEmpty()){
            $command = $this->getCommand();
            $command->execute();
        }
    }

    /**
     * We make this class a singleton
     * @return Queue
     */
    public static function get(){
        static $instance;
        if(!isset($instance)){
            $instance = new Queue();
        }
        return $instance;
    }
}