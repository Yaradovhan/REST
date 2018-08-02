<?php

class Delete
{
    private $table;
    private $where;


    public function __construct($table)
    {
        $this->table($table);
        $this->where = new Condition("WHERE");
    }


    public function table($table)
    {
        $this->table = $table;
        return $this;
    }


    public function where($conditions)
    {
        $this->where->setConditions($conditions);
        return $this;
    }

    public function build()
    {
        $query = "DELETE FROM {$this->table}";
        list($whereQuery) = $this->where->build();
        return $query . $whereQuery;
    }
}
