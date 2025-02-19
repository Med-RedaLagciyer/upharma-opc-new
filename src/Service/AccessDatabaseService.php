<?php

namespace App\Service;

class AccessDatabaseService
{
    private $dsn;
    private $username;
    private $password;
    private $connection;

    public function __construct(string $dsn = null, string $username = '', string $password = '')
    {
        // $this->dsn = 'Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=C:\\Users\\DEV\\Desktop\\access\\Requette.accdb;';
        $this->dsn = 'Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=\\\172.16.0.15\\afric_med\\AFRIC_MED_DB.accdb;charset=UTF-8;Uid=hcz\dev;Pwd=123;';
        // $this->dsn = 'Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=\\\172.16.0.37\\test\\AFRIC_MED_DB.accdb;charset=UTF-8;Uid=COSWIN;Pwd=COSWIN8;';
        // $this->dsn = 'Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=\\\172.16.0.15\\afric_med\\AFRIC_MED_DB.accdb;charset=UTF-8;Uid=dev1;Pwd=123;';
        // $this->username = 'dev1';
        // $this->password = '123';

        if (!$this->dsn) {
            throw new \Exception("DSN is required for database connection.");
        }

        $this->connect();
    }


    private function connect(): void
    {
        $this->connection = odbc_pconnect($this->dsn, $this->username, $this->password);

        if (!$this->connection) {
            throw new \Exception("Failed to connect to Access database. Error: " . odbc_errormsg());
        }
    }

    public function query(string $sql): array
    {
        $result = odbc_exec($this->connection, $sql);

        if (!$result) {
            throw new \Exception("Failed to execute query: '{$sql}'. Error: " . odbc_errormsg($this->connection));
        }

        $data = [];
        while ($row = odbc_fetch_array($result)) {
            $data[] = $row;
        }

        return $data;
    }


    public function execute(string $sql): void
    {
        $result = odbc_exec($this->connection, $sql);

        if (!$result) {
            throw new \Exception("Failed to execute query: '{$sql}'. Error: " . odbc_errormsg($this->connection));
        }
    }

    public function close(): void
    {
        if ($this->connection) {
            odbc_close($this->connection);
        }
    }
    public function __destruct()
    {
        $this->close();
    }
}
