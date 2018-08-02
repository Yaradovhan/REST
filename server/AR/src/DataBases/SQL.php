<?php

class SQL
{

    private $dsn;
    private $user;
    private $password;
    public $dbh;

    public function connect()
    {
        $this->dbh = new PDO($this->getDsn(), $this->getUser(), $this->getPassword());
    }

    public function getDsn()
    {
        return $this->dsn;
    }

    public function setDsn($dsn)
    {
        $this->dsn = $dsn;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param $sql
     * @param null $binds
     * @return mixed
     * @throws Exception
     */
    public function prepareExecute($sql, $binds = null)
    {
        $stmt = $this->dbh->prepare($sql);
        if (isset ($binds)) {
            foreach ($binds as $id => &$bind) {
                if (is_int($bind)) {
                    $stmt->bindParam(":$id", $bind, PDO::PARAM_INT);
                } else {
                    $stmt->bindParam(":$id", $bind, PDO::PARAM_STR);
                }
            }
        }
        $stmt->execute();
        return $stmt;
    }

}
