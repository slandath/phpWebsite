<?php

class Database
{
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $connection;
    public $statement;

    public function __construct($host, $dbname, $user, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
        $this->connect();
    }

    private function connect()
    {
        $conn_string = "host=$this->host dbname=$this->dbname user=$this->user password=$this->password";
        $this->connection = pg_connect($conn_string);

        if (!$this->connection) {
            die("Error: Failed to connect to PostgreSQL database." . pg_last_error());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function close()
    {
        pg_close($this->connection);
    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return $this;
    }
    public function get()
    {
        return $this->statement->fetchAll();
    }
}
