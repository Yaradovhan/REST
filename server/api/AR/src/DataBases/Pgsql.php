<?php

class Pgsql extends SQL
{

    public function __construct()
    {
        $this->setDsn(DSN_PG.':host=localhost;dbname='. DATABASE);
        $this->setUser(USER);
        $this->setPassword(PASSWORD);
        $this->connect();
    }

}
