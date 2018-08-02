<?php

class Mysql extends SQL
{

    protected $con;

    public function __construct()
    {
        $this->setDsn(DSN_MY . ':host=localhost;dbname=' . DATABASE);
        $this->setUser(USER);
        $this->setPassword(PASSWORD);
        $this->connect();
        $this->con = $this->dbh;
    }

}
